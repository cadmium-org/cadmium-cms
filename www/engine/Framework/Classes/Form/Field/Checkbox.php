<?php

namespace Form\Field {

	use Form\Utils;

	class Checkbox extends Utils\Field {

		# Constructor

		public function __construct(Form $form, string $key) {

			self::init($form, $key);
		}

		# Set value

		public function set(bool $value) {

			$this->value = $value;

			return (!($this->required && (false === $this->value)));
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
