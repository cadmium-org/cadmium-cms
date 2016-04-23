<?php

namespace {

	abstract class Template {

		private static $globals = [], $widgets = [];

		# Set/get global variable

		public static function global(string $name, string $value = null) {

			if (null === $value) return (self::$globals[$name] ?? false);

			if (!isset(self::$globals[$name])) self::$globals[$name] = $value;
		}

		# Set/get widget

		public static function widget(string $name, Template\Asset\Block $block = null) {

			if (null === $block) return (self::$widgets[$name] ?? false);

			if (!isset(self::$widgets[$name])) self::$widgets[$name] = $block;
		}

		# Get a list of global variables

		public static function globals() {

			return self::$globals;
		}

		# Get a list of widgets

		public static function widgets() {

			return self::$widgets;
		}

		# Create block

		public static function block(string $contents = '', bool $parse = true) {

			return new Template\Asset\Block($contents, $parse);
		}

		# Create group

		public static function group() {

			return new Template\Asset\Group();
		}

		# Check if object is block

		public static function isBlock($object) {

			return ($object instanceof Template\Asset\Block);
		}

		# Check if object is group

		public static function isGroup($object) {

			return ($object instanceof Template\Asset\Group);
		}

		# Output contents

		public static function output(Template\Asset\Block $block, $status = null) {

			if ((null === $status) || !Headers::isStatusCode($status)) $status = STATUS_CODE_200;

			Headers::nocache(); Headers::status($status); Headers::content(MIME_TYPE_HTML);

			# ------------------------

			echo $block->contents();
		}
	}
}
