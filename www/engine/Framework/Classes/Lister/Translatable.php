<?php

namespace Lister {

	use Language, Lister;

	abstract class Translatable extends Lister {

		# Get item by key

		public static function get($key) {

			if (null === ($value = parent::get($key))) return null;

			return ((null !== ($translated = Language::get($value))) ? $translated : $value);
		}

		# Get list

		public static function list() {

			foreach (parent::list() as $key => $value) {

				yield ((null !== ($translated = Language::get($value))) ? $translated : $value);
			}
		}
	}
}
