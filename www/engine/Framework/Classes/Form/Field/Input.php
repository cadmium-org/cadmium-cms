<?php

namespace Form\Field {

	use Form\Utils, String;

	class Input extends Utils\Implementable {

		private $type = FORM_INPUT_TEXT, $maxlength = 0, $placeholder = '', $readonly = false, $translit = false;

		# Set value

        protected function set($value) {

			$this->value = strval($value);

			if ($this->type !== FORM_INPUT_PASSWORD) {

				$multiline = ($this->type === FORM_INPUT_TEXTAREA);

    			$this->value = String::input($this->value, $multiline, $this->maxlength);

    			if ($this->translit) $this->value = String::translit($this->value, $this->maxlength);
            }

            return (!($this->required && ('' === $this->value)));
	    }

		# Constructor

		public function __construct($form, $name, $value, $type = FORM_INPUT_TEXT, $maxlength = 0, $placeholder = '') {

			parent::__construct($form, $name);

			$this->type = strval($type); $this->maxlength = intabs($maxlength);

			$this->placeholder = strval($placeholder);

			$this->set($value);
		}

		# Set readonly

        public function readonly($value) {

            $this->readonly = boolval($value);
        }

		# Set translit

		public function translit($value) {

            $this->translit = boolval($value);
        }

		# Get type

        private function getType() {

			if ($this->type === FORM_INPUT_PASSWORD) return 'password';

			if ($this->type === FORM_INPUT_HIDDEN) return 'hidden';

			if ($this->type === FORM_INPUT_TEXTAREA) return false;

            # ------------------------

            return 'text';
        }

		# Get value

		private function getValue() {

			if (in_array($this->type, array(FORM_INPUT_CAPTCHA, FORM_INPUT_PASSWORD))) return '';

			if ($this->type === FORM_INPUT_TEXTAREA) return false;

            # ------------------------

            return $this->value;
        }

		# Get block

		public function block() {

            $tag = $this->getTag(($this->type === FORM_INPUT_TEXTAREA) ? 'textarea' : 'input');

			# Set type

            if (false !== ($type = $this->getType())) $tag->set('type', $type);

			# Set value

			if (false !== ($value = $this->getValue())) $tag->set('value', $value);

            # Set appearance

			if ($this->type !== FORM_INPUT_HIDDEN) {

				if (0 !== $this->maxlength) $tag->set('maxlength', $this->maxlength);

				if ('' !== $this->placeholder) $tag->set('placeholder', $this->placeholder);

				if ($this->readonly) $tag->set('readonly', 'readonly');
			}

			# Set contents

			if ($this->type === FORM_INPUT_TEXTAREA) $tag->contents($this->value);

			# ------------------------

			return $tag->block();
		}
	}
}
