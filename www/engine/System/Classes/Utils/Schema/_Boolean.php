<?php

namespace Utils\Schema {

	class _Boolean {

		# Validate value

		public function validate($value) {

			return (is_scalar($value) ? boolval($value) : null);
		}
	}
}
