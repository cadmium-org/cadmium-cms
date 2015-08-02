<?php

namespace Form\Field {

	use Form\Utils, Request;

	class Virtual extends Utils\Field {

		# Constructor

		public function __construct($form, $name, $value = '') {

			$this->setForm($form); $this->setName($name); $this->value = strval($value);
		}

		# Catch POST value

		public function post() {

			if ($this->posted || ('' === ($name = $this->getName()))) return false;

			if (null === ($value = Request::post($name))) return false;

			$this->value = $value;

			# ------------------------

			return ($this->posted = true);
		}
	}
}
