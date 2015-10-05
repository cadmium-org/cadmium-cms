<?php

namespace System\Modules\Entitizer\Utils\Param\General {

	use System\Modules\Entitizer;

	abstract class Number extends Entitizer\Utils\Param {

		# Constructor

		public function __construct($name) {

			$this->name = strval($name);
		}

		# Validate value

		public function validate($value) {

			return intabs($value);
		}
	}
}
