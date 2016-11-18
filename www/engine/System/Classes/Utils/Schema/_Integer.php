<?php

namespace Utils\Schema {

	class _Integer {

		# Validate value

		public function validate($value) {

			return (is_scalar($value) ? intval($value) : null);
		}
	}
}
