<?php

namespace {

	# Cast variable to unsigned integer

	function intabs($value, $max = null) {

		$value = (int) abs(intval($value));

		if ((null !== $max) && ($value > ($max = (int) abs(intval($max))))) return $max;

		# ------------------------

		return $value;
	}

	# Cast variable to boolean

	if (!function_exists('boolval')) {

		function boolval($value) {

			return filter_var($value, FILTER_VALIDATE_BOOLEAN);
		}
	}
}
