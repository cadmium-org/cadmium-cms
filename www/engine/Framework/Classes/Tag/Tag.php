<?php

namespace {

	class Tag {

		private static $block_regular, $block_self_closing;

		private $name = '', $attributes = [], $contents = null;

		# Autoloader

		public static function __autoload() {

			self::$block_regular = new Tag\View\Regular();

			self::$block_self_closing = new Tag\View\SelfClosing();
		}

		# Constructor

		public function __construct($name, array $attributes = [], $contents = null) {

			$this->name = strval($name);

			foreach ($attributes as $name => $value) $this->set($name, $value);

			$this->contents($contents);
		}

		# Set attribute

		public function set($name, $value) {

			$name = strval($name); $value = strval($value);

			$this->attributes[$name] = $value;
		}

		# Set contents

		public function contents($contents) {

			if (null === $contents) $this->contents = null;

			if (Template::isSettable($contents)) $this->contents = $contents;

			else $this->contents = Template::block(String::output($contents), false);
		}

		# Get block

		public function block() {

			$block = ((null !== $this->contents) ? clone self::$block_regular : clone self::$block_self_closing);

			$block->name = $this->name;

			$block->attributes = Arr::index($this->attributes, 'name', 'value');

			$block->contents = $this->contents;

			# ------------------------

			return $block;
		}
	}
}
