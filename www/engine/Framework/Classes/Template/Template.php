<?php

namespace {

	abstract class Template {

		private static $globals = [];

		# Set global variable

		public static function set(string $name, string $value) {

			self::$globals[$name] = $value;
		}

		# Get global variable

		public static function get(string $name) {

			return (isset(self::$globals[$name]) ? self::$globals[$name] : false);
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

		# Check if object is settable

		public static function isSettable($object) {

			return ($object instanceof Template\Utils\Settable);
		}

		# Output contents

		public static function output(Template\Utils\Settable $block, $format = false, $status = null) {

			if ((null === $status) || !Headers::isStatusCode($status)) $status = STATUS_CODE_200;

			Headers::nocache(); Headers::status($status); Headers::content(MIME_TYPE_HTML);

			# ------------------------

			echo $block->contents($format);
		}
	}
}
