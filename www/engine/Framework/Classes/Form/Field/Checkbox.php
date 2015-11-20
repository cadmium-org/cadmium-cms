<?php

namespace Form\Field {

	use Form, Form\Utils;

	class Checkbox extends Utils\Field {

		# Field default value

		protected $value = false;

		# Constructor

		public function __construct(Form $form, string $key, bool $value = false) {

			# Init field

			self::init($form, $key);

			# Set value

			$this->set($value);
		}

		# Set value

		public function set(bool $value) {

			$this->value = $value;

			# Check for errors

			if ($this->required && (false === $this->value)) return 'required';

			# ------------------------

			return true;
		}

		# Get block

		public function block() {

			$tag = $this->getTag('input');

			$tag->set('type', 'checkbox');

			if (false !== $this->value) $tag->set('checked', 'checked');

			# ------------------------

			return $tag->block();
		}
	}
}
