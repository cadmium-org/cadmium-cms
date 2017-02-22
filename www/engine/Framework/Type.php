<?php

/**
 * @package Cadmium\Framework
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Type {

	abstract class Type {

		protected $value = null;

		/**
		 * Get value
		 *
		 * @return mixed : an object value
		 */

		 public function get() {

 			return $this->value;
 		}
	}

	abstract class _String extends Type {

		/**
		 * Constructor
		 */

		public function __construct(string $value) {

			$this->value = $value;
		}
	}

	abstract class _Integer extends Type {

		/**
		 * Constructor
		 */

		public function __construct(int $value) {

			$this->value = $value;
		}
	}

	# String types

	class Not extends _String {}

	class Like extends _String {}

	# Integer types

	class LessThan extends _Integer {}

	class GreaterThan extends _Integer {}

	class LessThanOrEqual extends _Integer {}

	class GreaterThanOrEqual extends _Integer {}
}
