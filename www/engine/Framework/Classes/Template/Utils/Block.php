<?php

namespace Template\Utils {

	use Template, Language, Number, String, Validate;

	class Block {

		private $contents = '', $enabled = true;

		private $blocks = array(), $loops = array(), $variables = array(), $phrases = array();

		# Parse collapased blocks

		private function parseCollapsedBlocks() {

			$pattern = ('/(?s){[ ]*(!)?[ ]*block[ ]*:[ ]*([a-zA-Z0-9_]+)[ ]*\/[ ]*}/');

			preg_match_all($pattern, $this->contents, $matches);

			foreach ($matches[2] as $key => $name) {

				if (!preg_match(REGEX_TEMPLATE_ITEM_NAME, $name)) continue;

				$this->contents = str_replace($matches[0][$key], ('{ block:' . $name . ' / }'), $this->contents);

				$this->blocks[$name] = new Block();

				if ($matches[1][$key]) $this->blocks[$name]->disable();
			}
		}

		# Parse expanded blocks

		private function parseExpandedBlocks() {

			$pattern = ('/(?s){[ ]*(!)?[ ]*block[ ]*:[ ]*([a-zA-Z0-9_]+)[ ]*}(.*?){[ ]*\/[ ]*block[ ]*:[ ]*\2[ ]*}/');

			preg_match_all($pattern, $this->contents, $matches);

			foreach ($matches[2] as $key => $name) {

				if (!preg_match(REGEX_TEMPLATE_ITEM_NAME, $name)) continue;

				$this->contents = str_replace($matches[0][$key], ('{ block:' . $name . ' / }'), $this->contents);

				$this->blocks[$name] = new Block($matches[3][$key]);

				if ($matches[1][$key]) $this->blocks[$name]->disable();
			}
		}

		# Parse loops

		private function parseLoops() {

			$pattern = ('/(?s){[ ]*for[ ]*:[ ]*([a-zA-Z0-9_]+)[ ]*}(.*?){[ ]*\/[ ]*for[ ]*:[ ]*\1[ ]*}/');

			preg_match_all($pattern, $this->contents, $matches);

			foreach ($matches[1] as $key => $name) {

				if (!preg_match(REGEX_TEMPLATE_ITEM_NAME, $name)) continue;

				$this->contents = str_replace($matches[0][$key], ('{ for:' . $name . ' / }'), $this->contents);

				$this->loops[$name] = array('block' => new Block($matches[2][$key]), 'range' => array(), 'separator' => '');
			}
		}

		# Parse variables

		private function parseVariables() {

			preg_match_all('/\$([a-zA-Z0-9_]+)\$/', $this->contents, $matches);

			foreach ($matches[1] as $index => $name) {

				if (!preg_match(REGEX_TEMPLATE_ITEM_NAME, $name)) continue;

				$this->contents = str_replace($matches[0][$index], ('$' . $name . '$'), $this->contents);

				$this->variables[$name] = null;
			}
		}

		# Parse phrases

		private function parsePhrases() {

			preg_match_all('/\%([a-zA-Z0-9_]+)\%/', $this->contents, $matches);

			foreach ($matches[1] as $index => $name) {

				if (!preg_match(REGEX_TEMPLATE_ITEM_NAME, $name)) continue;

				$this->contents = str_replace($matches[0][$index], ('%' . $name . '%'), $this->contents);

				$this->phrases[$name] = false;
			}
		}

		# Get loop contents

		private function getLoopContents($block, $range) {

			$loop = new Group();

			foreach ($range as $item) {

				$loop->add($loop_item = clone($block));

				foreach ($item as $name => $value) $loop_item->set($name, $value);
			}

			return $loop->contents();
		}

		# Constructor

		public function __construct($contents = '', $parse = true) {

			$this->contents = strval($contents);

			if (!Validate::boolean($parse)) return;

			$this->parseCollapsedBlocks(); $this->parseExpandedBlocks();

			$this->parseLoops(); $this->parseVariables(); $this->parsePhrases();
		}

		# Cloner

		public function __clone() {

			foreach ($this->blocks as $name => $block) if (is_object($block)) $this->blocks[$name] = clone $block;
		}

		# Setter

		public function __set($name, $value) {

			if (Template::settable($value)) $this->block($name, $value);

			else if (is_array($value)) $this->loop($name, $value); else $this->set($name, $value);
		}

		# Set block

		public function block($name, $block = null) {

			$name = strval($name);

			if (!isset($this->blocks[$name])) return ((null === $block) ? new Block() : false);

			if (null === $block) return $this->blocks[$name];

			if (Template::settable($block)) $this->blocks[$name] = $block;

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

			$value = strval($value); $raw = Validate::boolean($raw); $maxlength = Number::unsigned($maxlength);

			$this->variables[$name] = ($raw ? $value : String::output($value, $maxlength));

			# ------------------------

			return true;
		}

		# Get contents

		public function contents($format = false) {

			if (!$this->enabled) return '';

			$format = Validate::boolean($format); $contents = $this->contents;

			# Insert variables

			foreach ($this->variables as $name => $value) {

				if (null !== $value) $contents = str_replace(('$' . $name . '$'), $value, $contents);
			}

			# Insert phrases

			foreach ($this->phrases as $name => $value) {

				if (false !== ($value = Language::get($name))) $contents = str_replace(('%' . $name . '%'), $value, $contents);
			}

			# Insert loops

			foreach ($this->loops as $name => $loop) {

				$replace = ((array() !== $loop['range']) ? $this->getLoopContents($loop['block'], $loop['range']) : '');

				$contents = str_replace('{ for:' . $name . ' / }', $replace, $contents);
			}

			# Insert blocks

			foreach ($this->blocks as $name => $block) {

				$replace = ((false !== $block) ? $block->contents() : '');

				$contents = str_replace('{ block:' . $name . ' / }', $replace, $contents);
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
