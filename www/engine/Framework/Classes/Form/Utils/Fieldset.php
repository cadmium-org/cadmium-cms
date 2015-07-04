<?php

namespace Form\Utils {

	use Form;

	class Fieldset {

		private $form = false;

		# Constructor

		public function __construct($form) {

			if ($form instanceof Form) $this->form = $form;
		}

		# Add captcha field

		public function captcha($name, $value = false, $maxlength = 0, $placeholder = false, $config = false) {

			if (false === $this->form) return false;

			$field = new Form\Field\Captcha($this->form, $name, $value, $maxlength, $placeholder, $config);

			# ------------------------

			return $this->form->add($field);
		}

		# Add checkbox field

		public function checkbox($name, $value = false, $config = false) {

			if (false === $this->form) return false;

			$field = new Form\Field\Checkbox($this->form, $name, $value, $config);

			# ------------------------

			return $this->form->add($field);
		}

		# Add hidden field

		public function hidden($name, $value = false) {

			if (false === $this->form) return false;

			$field = new Form\Field\Hidden($this->form, $name, $value);

			# ------------------------

			return $this->form->add($field);
		}

		# Add password field

		public function password($name, $value = false, $maxlength = 0, $placeholder = false, $config = false) {

			if (false === $this->form) return false;

			$field = new Form\Field\Password($this->form, $name, $value, $maxlength, $placeholder, $config);

			# ------------------------

			return $this->form->add($field);
		}

		# Add select field

		public function select($name, $value, $options, $default = false, $search = false, $config = false) {

			if (false === $this->form) return false;

			$field = new Form\Field\Select($this->form, $name, $value, $options, $default, $search, $config);

			# ------------------------

			return $this->form->add($field);
		}

		# Add text field

		public function text($name, $value = false, $maxlength = 0, $placeholder = false, $config = false) {

			if (false === $this->form) return false;

			$field = new Form\Field\Text($this->form, $name, $value, $maxlength, $placeholder, $config);

			# ------------------------

			return $this->form->add($field);
		}

		# Add textarea field

		public function textarea($name, $value = false, $maxlength = 0, $rows = 0, $placeholder = false, $config = false) {

			if (false === $this->form) return false;

			$field = new Form\Field\Textarea($this->form, $name, $value, $maxlength, $rows, $placeholder, $config);

			# ------------------------

			return $this->form->add($field);
		}

		# Add virtual field

		public function virtual($name, $value = false) {

			if (false === $this->form) return false;

			$field = new Form\Field\Virtual($this->form, $name, $value);

			# ------------------------

			return $this->form->add($field);
		}
	}
}

?>
