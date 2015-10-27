<?php

namespace {

    # Check if value is empty

    function is_empty($value) {

        return empty($value);
    }

	# Cast variable to unsigned integer

	function intabs($value) {

		return (int) abs(intval($value));
	}

	# Cast variable to unsigned float

	function floatabs($value) {

		return (float) abs(floatval($value));
	}

	# Cast variable to boolean

	if (!function_exists('boolval')) {

		function boolval($value) {

			return (bool) $value;
		}
	}
}
