<?php

namespace Form\Field {

	use Form\Utils;

	class Checkbox extends Utils\Implementable {

		# Constructor

		public function __construct($form, $name, $value = false) {

			parent::__construct($form, $name);

			$this->set($value);
		}

		# Set value

        public function set($value) {

            $this->value = boolval($value);

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
