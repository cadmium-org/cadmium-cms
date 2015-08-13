<?php

namespace Form\Utils {

	use Form, Request;

	class Field {

		private $form = null, $posted = false;

		protected $key = '', $name = '', $value = null;

		# Validate form

		public function __construct($form, $key) {

			if ($form instanceof Form) $this->form = $form;

			$key = strval($key);

			if (preg_match(REGEX_FORM_FIELD_KEY, $key)) {

				$prefix = ((null !== $this->form) ? $this->form->name() : '');

				$this->key = $key; $this->name = (($prefix ? ($prefix . '_') : '') . $key);
			}
		}

		# Post value

		public function post() {

			if ($this->posted || ('' === $this->key)) return false;

			$this->value = Request::post($this->name);

			# ------------------------

			return ($this->posted = true);
		}

		# Return key

		public function key() {

			return $this->key;
		}

		# Return name

		public function name() {

			return $this->name;
		}

		# Return value

		public function value() {

			return $this->value;
		}
	}
}
