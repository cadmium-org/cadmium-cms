<?php

namespace Form\Field {

	use Form\Utils;

	class Checkbox extends Utils\Implementable {

		# Constructor

		public function __construct(Form $form, string $key, bool $value = null) {

			parent::__construct($form, $key);

			$this->set($value);
		}

		# Set value

		public function set(bool $value) {

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
