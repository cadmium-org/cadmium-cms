<?php

namespace {

	abstract class Template {

		private static $globals = [];

		# Set global variable

		public static function set($name, $value) {

			$name = strval($name); $value = strval($value);

			self::$globals[$name] = $value;
		}

		# Create block

		public static function block($contents = '', $parse = true) {

			$block = new Template\Utils\Block($contents, $parse);

			foreach (self::$globals as $name => $value) $block->set($name, $value);

			# ------------------------

			return $block;
		}

		# Create group

		public static function group() {

			return new Template\Utils\Group();
		}

		# Check if object is block

		public static function isBlock($object) {

			return ($object instanceof Template\Utils\Block);
		}

		# Check if object is group

		public static function isGroup($object) {

			return ($object instanceof Template\Utils\Group);
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
