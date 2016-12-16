<?php

/**
 * @package Cadmium\Framework\Template
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Template {

	use Language, Str, Template;

	class Block extends Group {

		private $contents = '', $enabled = true;

		private $blocks = [], $loops = [], $widgets = [], $variables = [], $phrases = [];

		/**
		 * Parse structures
		 */

		private function parseStructures() {

			preg_match_all(REGEX_TEMPLATE_STRUCTURE, $this->contents, $matches);

			foreach ($matches[0] as $key => $match) {

				$toggle = (($matches[1][$key] === '!') ? 'disable' : 'enable');

				$type = $matches[2][$key]; $name = $matches[3][$key]; $contents = ($matches[4][$key] ?? '');

				if (!preg_match(REGEX_TEMPLATE_COMPONENT_NAME, $name)) continue;

				$this->contents = str_replace($match, ('{ ' . $type . ':' . $name . ' / }'), $this->contents);

				if ($type === 'block') $this->blocks[$name] = (new Block($contents))->$toggle();

				else if ($type === 'for') $this->loops[$name] = new Loop($contents);

				else if ($type === 'widget') $this->widgets[] = $name;
			}
		}

		/**
		 * Parse elementaries
		 */

		private function parseElementaries() {

			$variables = ['pattern' => REGEX_TEMPLATE_VARIABLE, 'stack' => &$this->variables ];

			$phrases = ['pattern' => REGEX_TEMPLATE_PHRASE, 'stack' => &$this->phrases ];

			foreach ([$variables, $phrases] as $elementaries) {

				preg_match_all($elementaries['pattern'], $this->contents, $matches);

				foreach ($matches[1] as $index => $name) {

					if (!preg_match(REGEX_TEMPLATE_COMPONENT_NAME, $name)) continue;

					$elementaries['stack'][$name] = false;
				}
			}
		}

		/**
		 * Build the block contents
		 */

		protected function buildContents() : string {

			$insertions = [];

			# Process blocks

			foreach ($this->blocks as $name => $block) {

				$insertions['{ block:' . $name . ' / }'] = $block->getContents();
			}

			# Process loops

			foreach ($this->loops as $name => $loop) {

				$insertions['{ for:' . $name . ' / }'] = $loop->getContents();
			}

			# Process widgets

			foreach ($this->widgets as $name) {

				$widget = Template::getWidget($name);

				$contents = ((false !== $widget) ? $widget->getContents() : '');

				$insertions['{ widget:' . $name . ' / }'] = $contents;
			}

			# Process variables

			foreach ($this->variables as $name => $value) {

				$value = ((false === $value) ? Template::getGlobal($name) : $value);

				$insertions['$' . $name . '$'] = Str::formatOutput($value);
			}

			# Process phrases

			foreach ($this->phrases as $name => $value) {

				$value = Language::get($name);

				$insertions['%' . $name . '%'] = Str::formatOutput($value);
			}

			# Process insertions

			$contents = str_replace(array_keys($insertions), array_values($insertions), $this->contents);

			# ------------------------

			return $contents;
		}

		/**
		 * Constructor
		 */

		public function __construct(string $contents = '') {

			$this->contents = $contents;

			$this->parseStructures(); $this->parseElementaries();
		}

		/**
		 * Cloner
		 */

		public function __clone() {

			foreach ($this->blocks as $name => $block) $this->blocks[$name] = clone $block;

			foreach ($this->loops as $name => $loop) $this->loops[$name] = clone $loop;

			foreach ($this->items as $name => $item) $this->items[$name] = clone $item;
		}

		/**
		 * Set a block, a loop, or a variable
		 *
		 * @return Template\Block : the current block object
		 */

		public function set(string $name, $value) : Block {

			if ($value instanceof Block) $this->setBlock($name, $value);

			else if (is_array($value)) $this->setLoop($name, $value);

			else if (is_scalar($value)) $this->setVar($name, $value);

			# ------------------------

			return $this;
		}

		/**
		 * Set multiple components (blocks, loops, or variables)
		 *
		 * @return Template\Block : the current block object
		 */

		public function setArray(array $components) : Block {

			foreach ($components as $name => $component) $this->set($name, $component);

			return $this;
		}

		/**
		 * Set a block
		 *
		 * @return Template\Block : the current block object
		 */

		public function setBlock(string $name, Block $block) : Block {

			if (isset($this->blocks[$name])) $this->blocks[$name] = $block;

			return $this;
		}

		/**
		 * Set a loop
		 *
		 * @return Template\Block : the current block object
		 */

		public function setLoop(string $name, array $items) : Block {

			if (isset($this->loops[$name])) $this->loops[$name]->setItems($items);

			return $this;
		}

		/**
		 * Set a variable
		 *
		 * @return Template\Block : the current block object
		 */

		public function setVar(string $name, string $value) : Block {

			if (isset($this->variables[$name])) $this->variables[$name] = $value;

			return $this;
		}

		/**
		 * Get a block, a loop, or a variable
		 *
		 * @return Template\Block|Template\Loop|string|false : the component or false if the component does not exist
		 */

		public function get(string $name) {

			return ($this->blocks[$name] ?? $this->loops[$name] ?? $this->variables[$name] ?? false);
		}

		/**
		 * Get a block. It's recommended to use this method instead of magic getter to avoid an error on getting nonexistent block
		 *
		 * @return Template\Block : the block or an empty block if the block does not exist
		 */

		public function getBlock(string $name) : Block {

			return ($this->blocks[$name] ?? new Block);
		}

		/**
		 * Get the blocks list
		 */

		public function getBlocks() : array {

			return $this->blocks;
		}

		/**
		 * Get a loop. It's recommended to use this method instead of magic getter to avoid an error on getting nonexistent loop
		 *
		 * @return Template\Loop : the loop or an empty loop if the loop does not exist
		 */

		public function getLoop(string $name) : Loop {

			return ($this->loops[$name] ?? new Loop);
		}

		/**
		 * Get the loops list
		 */

		public function getLoops() : array {

			return $this->loops;
		}

		/**
		 * Get a variable
		 *
		 * @return string|false : the value or false if the variable does not exist
		 */

		public function getVar(string $name) {

			return ($this->variables[$name] ?? false);
		}

		/**
		 * Get the variable list
		 */

		public function getVars() : array {

			return $this->variables;
		}

		/**
		 * Get the block contents
		 */

		public function getContents() : string {

			if (!$this->enabled) return '';

			# Lock the block

			$this->enabled = false;

			# Generate contents

			$contents = ((0 === $this->count) ? $this->buildContents() : parent::getContents());

			# Unlock the block

			$this->enabled = true;

			# ------------------------

			return $contents;
		}

		/**
		 * Disable the block
		 *
		 * @return Template\Block : the current block object
		 */

		public function disable() : Block {

			$this->enabled = false;

			return $this;
		}

		/**
		 * Enable the block
		 *
		 * @return Template\Block : the current block object
		 */

		public function enable() : Block {

			$this->enabled = true;

			return $this;
		}

		/**
		 * Check if the block is enabled
		 */

		public function isEnabled() : bool {

			return $this->enabled;
		}

		/**
		 * An alias for the set method
		 */

		public function __set(string $name, $value) : Block {

			return $this->set($name, $value);
		}

		/**
		 * An alias for the get method
		 */

		public function __get(string $name) {

			return $this->get($name);
		}

		/**
		 * Check if a component exists
		 */

		public function __isset(string $name) : bool {

			return (isset($this->blocks[$name]) || isset($this->loops[$name]) || isset($this->variables[$name]));
		}
	}
}
