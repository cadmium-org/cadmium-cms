<?php

namespace Template\Utils {

	use Language, Template, String;

	class Block implements Settable {

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

				$this->loops[$name] = ['block' => new Block($matches[2][$key]), 'range' => [], 'separator' => ''];
			}
		}

		# Parse variables

		private function parseVariables() {

			$variables = ['stack' => &$this->variables, 'pattern' => REGEX_TEMPLATE_VARIABLE];

			$phrases = ['stack' => &$this->phrases, 'pattern' => REGEX_TEMPLATE_PHRASE];

			foreach ([$variables, $phrases] as $variables) {

				preg_match_all($variables['pattern'], $this->contents, $matches);

				foreach ($matches[1] as $index => $name) {

					if (!preg_match(REGEX_TEMPLATE_ITEM_NAME, $name)) continue;

					$variables['stack'][$name] = null;
				}
			}
		}

		# Get loop contents

		private function getLoopContents($block, $range) {

			$loop = new Group();

			foreach ($range as $item) {

				$loop->add($block = clone($block));

				foreach ($item as $name => $value) $block->set($name, $value);
			}

			return $loop->contents();
		}

		# Constructor

		public function __construct($contents = '', $parse = true) {

			$this->contents = strval($contents); $parse = boolval($parse);

			if ($parse) { $this->parseBlocks(); $this->parseLoops(); $this->parseVariables(); }
		}

		# Cloner

		public function __clone() {

			foreach ($this->blocks as $name => $block) $this->blocks[$name] = clone $block;
		}

		# Setter

		public function __set($name, $value) {

			if ($value instanceof Settable) $this->block($name, $value);

			else if (is_array($value)) $this->loop($name, $value); else $this->set($name, $value);
		}

		# Set block

		public function block($name, Settable $block = null) {

			$name = strval($name);

			if (!isset($this->blocks[$name])) return ((null === $block) ? new Block() : false);

			if (null === $block) return $this->blocks[$name];

			$this->blocks[$name] = $block;

			# ------------------------

			return true;
		}

		# Set loop

		public function loop($name, array $range, $separator = '') {

			$name = strval($name); $separator = strval($separator);

			if (!isset($this->loops[$name])) return false;

			$this->loops[$name]['range'] = $range; $this->loops[$name]['separator'] = $separator;

			# ------------------------

			return true;
		}

		# Set variable

		public function set($name, $value, $raw = false, $maxlength = 0) {

			$name = strval($name);

			if (!array_key_exists($name, $this->variables)) return false;

			$value = strval($value); $raw = boolval($raw); $maxlength = intabs($maxlength);

			$this->variables[$name] = ($raw ? $value : String::output($value, $maxlength));

			# ------------------------

			return true;
		}

		# Get contents

		public function contents($format = false) {

			if (!$this->enabled) return '';

			$format = boolval($format); $contents = $this->contents;

			# Insert variables

			$globals = ['stack' => Template::globals(), 'symbol' => '$', 'language' => false];

			$locals = ['stack' => &$this->variables, 'symbol' => '$', 'language' => false];

			$phrases = ['stack' => &$this->phrases, 'symbol' => '%', 'language' => true];

			foreach ([$globals, $locals, $phrases] as $variables) {

				foreach ($variables['stack'] as $name => $value) {

					if (null === ($value = ($variables['language'] ? Language::get($name) : $value))) continue;

					$contents = str_replace(($variables['symbol'] . $name . $variables['symbol']), $value, $contents);
				}
			}

			# Insert phrases

			foreach ($this->phrases as $name => $value) {

				if (null !== ($value = Language::get($name))) $contents = str_replace(('%' . $name . '%'), $value, $contents);
			}

			# Insert loops

			foreach ($this->loops as $name => $loop) {

				$replace = $this->getLoopContents($loop['block'], $loop['range']);

				$contents = str_replace('{ for:' . $name . ' / }', $replace, $contents);
			}

			# Insert blocks

			foreach ($this->blocks as $name => $block) {

				$contents = str_replace('{ block:' . $name . ' / }', $block->contents(), $contents);
			}

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
