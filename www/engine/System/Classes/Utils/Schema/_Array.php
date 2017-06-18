<?php

/**
 * @package Cadmium\System\Utils
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Utils\Schema {

	class _Array extends _Object {

		/**
		 * Validate data
		 *
		 * @return array|null : the validated data or null on failure
		 */

		public function validate($data) {

			if (!is_array($data)) return null;

			$result = [];

			foreach ($data as $item) {

				if (!is_array($item) || (null === ($item = parent::validate($item)))) return null;

				$result[] = $item;
			}

			# ------------------------

			return $result;
		}
	}
}
