<?php

namespace Template\Asset {

	use Language, Template, Text;

	class Block implements Template\Utils\Settable {

		private $contents = '', $enabled = true;

		private $blocks = [], $loops = [], $variables = [], $phrases = [];

		# Parse collapased blocks

		private function parseBlocks() {

			preg_match_all(REGEX_TEMPLATE_BLOCK, $this->contents, $matches);

			foreach ($matches[2] as $key => $name) {

				if (!preg_match(REGEX_TEMPLATE_ITEM_NAME, $name)) continue;

				$this->contents = str_replace($matches[0][$key], ('{ block:' . $name . ' / }'), $this->contents);

				$this->blocks[$name] = new Block(isset($matches[4]) ? $matches[4][$key] : '');

				if ($matches[1][$key]) $this->blocks[$name]->disable();
			}
		}

		# Parse loops

		private function parseLoops() {

			preg_match_all(REGEX_TEMPLATE_LOOP, $this->contents, $matches);

			foreach ($matches[1] as $key => $name) {

				if (!preg_match(REGEX_TEMPLATE_ITEM_NAME, $name)) continue;

				$this->contents = str_replace($matches[0][$key], ('{ for:' . $name . ' / }'), $this->contents);

				$this->loops[$name] = new Template\Utils\Loop(new Block($matches[2][$key]));
			}
		}

		# Parse variables & phrases

		private function parseElementaries() {

			$variables = ['stack' => &$this->variables, 'pattern' => REGEX_TEMPLATE_VARIABLE];

			$phrases = ['stack' => &$this->phrases, 'pattern' => REGEX_TEMPLATE_PHRASE];

			foreach ([$variables, $phrases] as $variables) {

				preg_match_all($variables['pattern'], $this->contents, $matches);

				foreach ($matches[1] as $index => $name) {

					if (!preg_match(REGEX_TEMPLATE_ITEM_NAME, $name)) continue;

					$variables['stack'][$name] = false;
				}
			}
		}

		# Constructor

		public function __construct(string $contents = '', bool $parse = true) {

			$this->contents = $contents;

			if ($parse) { $this->parseBlocks(); $this->parseLoops(); $this->parseElementaries(); }
		}

		# Cloner

		public function __clone() {

			foreach ($this->blocks as $name => $block) $this->blocks[$name] = clone $block;

			foreach ($this->loops as $name => $loop) $this->loops[$name] = clone $loop;
		}

		# Setter

		public function __set(string $name, $value) {

			if ($value instanceof Template\Utils\Settable) $this->block($name, $value);

			else if (is_array($value)) $this->loop($name, $value); else $this->set($name, $value);
		}

		# Set block

		public function block(string $name, Template\Utils\Settable $block = null) {

			if (!isset($this->blocks[$name])) return ((null === $block) ? new Block() : false);

			if (null === $block) return $this->blocks[$name];

			$this->blocks[$name] = $block;

			# ------------------------

			return true;
		}

		# Set loop

		public function loop(string $name, array $range = null, string $separator = '') {

			if (!isset($this->loops[$name])) return ((null === $range) ? new Template\Utils\Loop() : false);

			if (null === $range) return $this->loops[$name];

			$this->loops[$name]->range($range); $this->loops[$name]->separator($separator);

			# ------------------------

			return true;
		}

		# Set variable

		public function set(string $name, string $value, bool $raw = false, int $maxlength = 0) {

			if (!isset($this->variables[$name])) return false;

			$this->variables[$name] = (!$raw ? Text::output($value, $maxlength) : $value);

			# ------------------------

			return true;
		}

		# Get contents

		public function contents(bool $format = false) {

			if (!$this->enabled) return '';

			$contents = $this->contents; $insertions = [];

			# Process variables

			foreach ($this->variables as $name => $value) {

				$value = ((false === $value) ? Template::get($name) : $value);

				if (false !== $value) $insertions['$' . $name . '$'] = $value;
			}

			# Process phrases

			foreach ($this->phrases as $name => $value) {

				$value = Language::get($name);

				if (false !== $value) $insertions['%' . $name . '%'] = $value;
			}

			# Process loops

			foreach ($this->loops as $name => $loop) {

				$insertions['{ for:' . $name . ' / }'] = $loop->contents();
			}

			# Process blocks

			foreach ($this->blocks as $name => $block) {

				$insertions['{ block:' . $name . ' / }'] = $block->contents();
			}

			# Insert values

			$contents = str_replace(array_keys($insertions), array_values($insertions), $contents);

			# ------------------------

			return ($format ? preg_replace('/[\n\r\t\s]+/', ' ', $contents) : $contents);
		}

		# Disable block

		public function disable() {

			$this->enabled = false;
		}

		# Enable block

		public function enable() {

			$this->enabled = true;
		}

		# Check if enabled

		public function enabled() {

			return $this->enabled;
		}
	}
}
