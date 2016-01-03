<?php

namespace Template\Asset {

	use Language, Str, Template;

	class Block {

		private $contents = '', $enabled = true;

		private $blocks = [], $loops = [], $widgets = [], $variables = [], $phrases = [];

		# Parse structures

		private function parseStructures() {

			preg_match_all(REGEX_TEMPLATE_STRUCTURE, $this->contents, $matches);

			foreach ($matches[0] as $key => $match) {

				$toggle = (($matches[1][$key] === '!') ? 'disable' : 'enable');

				$type = $matches[2][$key]; $name = $matches[3][$key]; $contents = ($matches[4][$key] ?? '');

				if (!preg_match(REGEX_TEMPLATE_ITEM_NAME, $name)) continue;

				$this->contents = str_replace($match, ('{ ' . $type . ':' . $name . ' / }'), $this->contents);

				if ($type === 'block') $this->blocks[$name] = (new Block($contents))->$toggle();

				else if ($type === 'for') $this->loops[$name] = new Loop($contents);

				else if ($type === 'widget') $this->widgets[] = $name;
			}
		}

		# Parse elementaries

		private function parseElementaries() {

			$variables = ['stack' => &$this->variables, 'pattern' => REGEX_TEMPLATE_VARIABLE];

			$phrases = ['stack' => &$this->phrases, 'pattern' => REGEX_TEMPLATE_PHRASE];

			foreach ([$variables, $phrases] as $elementaries) {

				preg_match_all($elementaries['pattern'], $this->contents, $matches);

				foreach ($matches[1] as $index => $name) {

					if (!preg_match(REGEX_TEMPLATE_ITEM_NAME, $name)) continue;

					$elementaries['stack'][$name] = false;
				}
			}
		}

		# Constructor

		public function __construct(string $contents = '', bool $parse = true) {

			$this->contents = $contents;

			if ($parse) { $this->parseStructures(); $this->parseElementaries(); }
		}

		# Cloner

		public function __clone() {

			foreach ($this->blocks as $name => $block) $this->blocks[$name] = clone $block;

			foreach ($this->loops as $name => $loop) $this->loops[$name] = clone $loop;
		}

		# Setter

		public function __set(string $name, $value) {

			if ($value instanceof Block) $this->block($name, $value);

			else if (is_array($value)) $this->loop($name, $value);

			else if (is_scalar($value)) $this->set($name, $value);
		}

		# Set block

		public function block(string $name, Block $block = null) {

			if (!isset($this->blocks[$name])) return ((null === $block) ? new Block() : $this);

			if (null === $block) return $this->blocks[$name];

			$this->blocks[$name] = $block;

			# ------------------------

			return $this;
		}

		# Set loop

		public function loop(string $name, array $range = null) {

			if (!isset($this->loops[$name])) return ((null === $range) ? new Loop() : $this);

			if (null === $range) return $this->loops[$name];

			$this->loops[$name]->range($range);

			# ------------------------

			return $this;
		}

		# Set variable

		public function set(string $name, string $value) {

			if (isset($this->variables[$name])) $this->variables[$name] = $value;

			return $this;
		}

		# Get contents

		public function contents() {

			if (!$this->enabled) return '';

			$this->enabled = false; $insertions = [];

			# Process blocks

			foreach ($this->blocks as $name => $block) {

				$insertions['{ block:' . $name . ' / }'] = $block->contents();
			}

			# Process loops

			foreach ($this->loops as $name => $loop) {

				$insertions['{ for:' . $name . ' / }'] = $loop->contents();
			}

			# Process widgets

			foreach ($this->widgets as $name) {

				if (false === ($widget = Template::widget($name))) continue;

				$insertions['{ widget:' . $name . ' / }'] = $widget->contents();
			}

			# Process variables

			foreach ($this->variables as $name => $value) {

				$value = ((false === $value) ? Template::global($name) : $value);

				if (false !== $value) $insertions['$' . $name . '$'] = Str::output($value);
			}

			# Process phrases

			foreach ($this->phrases as $name => $value) {

				$value = Language::get($name);

				if (false !== $value) $insertions['%' . $name . '%'] = Str::output($value);
			}

			# Unlock and process insertions

			$this->enabled = true;

			$contents = str_replace(array_keys($insertions), array_values($insertions), $this->contents);

			# ------------------------

			return $contents;
		}

		# Disable block

		public function disable() {

			$this->enabled = false;

			return $this;
		}

		# Enable block

		public function enable() {

			$this->enabled = true;

			return $this;
		}

		# Check if enabled

		public function enabled() {

			return $this->enabled;
		}
	}
}
