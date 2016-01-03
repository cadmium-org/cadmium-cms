<?php

namespace {

	class Tag {

		private static $block_regular = null, $block_self_closing = null;

		private $name = '', $attributes = [], $contents = null;

		# Autoloader

		public static function __autoload() {

			self::$block_regular = new Tag\View\Regular();

			self::$block_self_closing = new Tag\View\SelfClosing();
		}

		# Constructor

		public function __construct(string $name, array $attributes = [], $contents = null) {

			$this->name = $name;

			foreach ($attributes as $name => $value) $this->set($name, $value);

			$this->contents($contents);
		}

		# Set attribute

		public function set(string $name, string $value) {

			$this->attributes[$name] = $value;

			return $this;
		}

		# Set contents

		public function contents($contents) {

			if ((null === $contents) || Template::isBlock($contents)) $this->contents = $contents;

			else if (is_scalar($contents)) $this->contents = Template::block('$contents$')->set('contents', $contents);

			# ------------------------

			return $this;
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
