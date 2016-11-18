<?php

/**
 * @package Framework\Tag
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2016, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace {

	class Tag {

		private static $block = null;

		private $name = '', $attributes = [], $contents = null;

		/**
		 * Constructor
		 */

		public function __construct(string $name, array $attributes = [], $contents = null) {

			$this->setName($name); $this->setAttributes($attributes); $this->setContents($contents);
		}

		/**
		 * Set a name
		 *
		 * @return the current tag object
		 */

		 public function setName(string $name) : Tag {

 			$this->name = $name;

 			return $this;
 		}

		/**
		 * Set an attribute
		 *
		 * @return the current tag object
		 */

		public function setAttribute(string $name, string $value) : Tag {

			$this->attributes[$name] = $value;

			return $this;
		}

		/**
		 * Set multiple attributes
		 *
		 * @return the current tag object
		 */

		public function setAttributes(array $attributes) : Tag {

			foreach ($attributes as $name => $value) if (is_scalar($value)) $this->setAttribute($name, $value);

			return $this;
		}

		/**
		 * Set contents. The method expects a block, a string, or null
		 *
		 * @return the current tag object
		 */

		public function setContents($contents) : Tag {

			if (Template::isBlock($contents) || is_scalar($contents) || is_null($contents)) $this->contents = $contents;

			return $this;
		}

		/**
		 * Get the tag name
		 */

		 public function getName() : string {

 			return $this->name;
 		}

		/**
		 * Get the tag attribute
		 *
		 * @return the value or false if the attribute does not exist
		 */

		public function getAttribute(string $name) {

			return ($this->attributes[$name] ?? false);
		}

		/**
		 * Get the tag attributes
		 */

		public function getAttributes() : array {

 			return $this->attributes;
 		}

		/**
		 * Get the tag as a block
		 *
		 * @return the self-closing tag if no valid contents have been set, otherwise the regular tag
		 */

		public function getBlock() : Template\Block {

			# Create block

			$block = clone (self::$block ?? (self::$block = Template::createBlock(

				'<$name${ for:attributes } $name$="$value$"{ / for:attributes }>' .

				'{ block:contents / }$contents${ ! block:closing }</$name$>{ / block:closing }'
			)));

			# Set name and attributes

			$block->name = $this->name;

			$block->attributes = Arr::index($this->attributes, 'name', 'value');

			# Set contents

			if (null !== $this->contents) {

				$block->contents = $this->contents; $block->closing->enable()->name = $this->name;
			}

			# ------------------------

			return $block;
		}
	}
}
