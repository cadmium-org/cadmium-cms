<?php

namespace Form\Utils {

	use Form;

	class Fieldset {

		private $form = null;

		# Add field to form

		private function add($field) {

			if (null === $this->form) return false;

			return $this->form->add($field);
		}

		# Constructor

		public function __construct($form) {

			if ($form instanceof Form) $this->form = $form;
		}

		# Add text field

		public function text($name, $value = '', $maxlength = 0, $placeholder = '', $config = 0) {

			$field = new Form\Field\Input($this->form, $name, $value, FORM_INPUT_TYPE_TEXT, $maxlength, 0, $placeholder, $config);

			return $this->add($field);
		}

		# Add password field

		public function password($name, $value = '', $maxlength = 0, $placeholder = '', $config = 0) {

			$field = new Form\Field\Input($this->form, $name, $value, FORM_INPUT_TYPE_PASSWORD, $maxlength, 0, $placeholder, $config);

			return $this->add($field);
		}

		# Add captcha field

		public function captcha($name, $value = '', $maxlength = 0, $placeholder = '', $config = 0) {

			$field = new Form\Field\Input($this->form, $name, $value, FORM_INPUT_TYPE_CAPTCHA, $maxlength, 0, $placeholder, $config);

			return $this->add($field);
		}

		# Add textarea field

		public function textarea($name, $value = '', $maxlength = 0, $rows = 0, $placeholder = '', $config = 0) {

			$field = new Form\Field\Input($this->form, $name, $value, FORM_INPUT_TYPE_TEXTAREA, $maxlength, $rows, $placeholder, $config);

			return $this->add($field);
		}

		# Add select field

		public function select($name, $value, array $options, $default = '', $config = 0) {

			$field = new Form\Field\Select($this->form, $name, $value, $options, $default, $config);

			return $this->add($field);
		}

		# Add checkbox field

		public function checkbox($name, $value = false, $config = 0) {

			$field = new Form\Field\Checkbox($this->form, $name, $value, $config);

			return $this->add($field);
		}

		# Add hidden field

		public function hidden($name, $value = '') {

			$field = new Form\Field\Hidden($this->form, $name, $value);

			return $this->add($field);
		}
	}
}
