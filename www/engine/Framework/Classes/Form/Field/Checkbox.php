<?php

namespace Form\Field {

	use Form, Form\Utils, Validate;

	class Checkbox extends Utils\Field {

		# Field default value

		protected $value = false;

		# Constructor

		public function __construct(Form $form, string $key, string $value = '', array $config = []) {

			# Init field

			self::init($form, $key, $config);

			# Set value

			$this->set($value);
		}

		# Set value

		public function set(string $value) {

			return ($this->value = Validate::boolean($value));
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
