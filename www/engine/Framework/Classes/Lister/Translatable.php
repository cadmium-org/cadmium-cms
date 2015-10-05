<?php

namespace Lister {

	use Language, Lister;

	abstract class Translatable extends Lister {

		# Get item by key

		public static function get($key) {

			if (false === ($value = parent::get($key))) return false;

			return ((null !== ($translated = Language::get($value))) ? $translated : $value);
		}

		# Get list

		public static function range() {

			$list = [];

			foreach (parent::range() as $key => $value) {

				$list[$key] = ((null !== ($translated = Language::get($value))) ? $translated : $value);
			}

			return $list;
		}
	}
}
