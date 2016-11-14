<?php

namespace Utils\Schema {

	class _String {

		# Validate value

		public function validate($value) {

			return (is_scalar($value) ? strval($value) : null);
		}
	}
}
