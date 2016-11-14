<?php

namespace Utils\Schema {

	class _Array extends _Object {

		# Validate data

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
