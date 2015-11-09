<?php

namespace Lister {

	use Language;

	abstract class Lister extends \Lister {

		# Get item by key

		public static function get($key) {

			if (false === ($value = parent::get($key))) return false;

			return ((false !== ($translated = Language::get($value))) ? $translated : $value);
		}

		# Get list

		public static function list() {

			foreach (parent::list() as $key => $value) {

				yield ((false !== ($translated = Language::get($value))) ? $translated : $value);
			}
		}
	}
}
