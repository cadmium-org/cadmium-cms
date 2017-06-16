<?php

/**
 * @package Cadmium\System\Utils
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Utils\Schema {

	class _Boolean {

		/**
		 * Validate a value
		 *
		 * @return bool|null : the validated value or null on failure
		 */

		public function validate($value) {

			return (is_scalar($value) ? boolval($value) : null);
		}
	}
}
