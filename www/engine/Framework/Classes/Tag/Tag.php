<?php

namespace {

	class Tag {

		private static $block_regular, $block_self_closing;

		private $name = '', $attributes = array(), $contents = null;

		# Autoloader

		public static function __autoload() {

			self::$block_regular = new Tag\View\Regular();

			self::$block_self_closing = new Tag\View\SelfClosing();
		}

		# Constructor

		public function __construct($name, array $attributes, $contents = null) {

			$this->name = strval($name); $this->attributes = Arr::index($attributes, 'name', 'value');

			if (null === $contents) return;

			$this->contents = (Template::settable($contents) ? $contents : new Template\Utils\Block(String::output($contents), false));
		}

		# Get block

		public function block() {

			$block = ((null !== $this->contents) ? clone self::$block_regular : clone self::$block_self_closing);

			$block->name = $this->name; $block->attributes = $this->attributes; $block->contents = $this->contents;

			# ------------------------

			return $block;
		}
	}
}
