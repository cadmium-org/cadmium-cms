<?php

namespace {

	abstract class Template {

		# Create block

		public static function block($contents = '', $parse = true) {

			return new Template\Utils\Block($contents, $parse);
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
