<?php

namespace Form\Field {

	use Form\Utils, String;

	class Input extends Utils\Implementable {

		private $type = FORM_INPUT_TEXT, $maxlength = 0, $placeholder = '', $readonly = false, $translit = false;

		private $autofocus = false, $autocomplete = false;

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

		# Set autofocus

		public function autofocus($value) {

            $this->autofocus = boolval($value);
        }

		# Set autocomplete

		public function autocomplete($value) {

            $this->autocomplete = boolval($value);
        }

		# Get hidden input tag

		private function getHidden() {

			return $this->getTag('input', array('type' => 'hidden', 'value' => $this->value));
		}

		# Get password input tag

		private function getPassword() {

			return $this->getTag('input', array('type' => 'password', 'value' => ''));
		}

		# Get textarea tag

		private function getTextarea() {

			return $this->getTag('textarea', array(), $this->value);
		}

		# Get text input tag

		private function getText() {

			$value = (($this->type !== FORM_INPUT_CAPTCHA) ? $this->value : '');

			return $this->getTag('input', array('type' => 'text', 'value' => $value));
		}

		# Get block

		public function block() {

			if ($this->type === FORM_INPUT_HIDDEN) {

				$tag = $this->getHidden();

			} else {

				if ($this->type === FORM_INPUT_PASSWORD) $tag = $this->getPassword();

				else if ($this->type === FORM_INPUT_TEXTAREA) $tag = $this->getTextarea();

				else $tag = $this->getText();

	            # Set appearance

				if (0 !== $this->maxlength) $tag->set('maxlength', $this->maxlength);

				if ('' !== $this->placeholder) $tag->set('placeholder', $this->placeholder);

				if ($this->readonly) $tag->set('readonly', 'readonly');

				if ($this->autofocus) $tag->set('autofocus', 'autofocus');

				if ($this->autocomplete) $tag->set('autocomplete', 'on');
			}

			# ------------------------

			return $tag->block();
		}
	}
}
