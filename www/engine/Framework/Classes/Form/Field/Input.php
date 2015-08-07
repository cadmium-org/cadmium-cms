<?php

namespace Form\Field {

	use Form\Utils, Request, String, Tag;

	class Input extends Utils\Field {

		private $type = FORM_INPUT_TEXT, $maxlength = 0, $placeholder = '', $readonly = false, $translit = false;

        # Get type

        private function getType() {

            if ($this->type === FORM_INPUT_TEXTAREA) return false;

            $type = (($this->type !== FORM_INPUT_PASSWORD) ? 'text' : 'password');

            # ------------------------

            return $type;
        }

        # Get value

        private function getValue() {

            if ($this->type === FORM_INPUT_TEXTAREA) return false;

            $value = (!in_array($this->type, array(FORM_INPUT_PASSWORD, FORM_INPUT_CAPTCHA)) ? $this->value : '');

            # ------------------------

            return $value;
        }

        # Get attributes

        protected function getAttributes() {

            $attributes = parent::getAttributes();

            # Set type

            if (false !== ($type = $this->getType())) $attributes['type'] = $type;

			# Set value

            if (false !== ($value = $this->getValue())) $attributes['value'] = $value;

            # Set appearance

			if (0 !== $this->maxlength) $attributes['maxlength'] = $this->maxlength;

			if ('' !== $this->placeholder) $attributes['placeholder'] = $this->placeholder;

			if ($this->readonly) $attributes['readonly'] = 'readonly';

            # ------------------------

            return $attributes;
        }

        # Get contents

        private function getContents() {

            return (($this->type === FORM_INPUT_TEXTAREA) ? $this->value : null);
        }

		# Set type

        public function type($type) {

            $this->type = strval($type);
        }

		# Set maxlength

        public function maxlength($maxlength) {

            $this->maxlength = intabs($maxlength);
        }

		# Set placeholder

		public function placeholder($value) {

            $this->placeholder = strval($value);
        }

		# Set readonly

        public function readonly($value) {

            $this->readonly = boolval($value);
        }

		# Set translit

		public function translit($value) {

            $this->translit = boolval($value);
        }

		# Catch POST value

		public function post() {

			if ($this->posted || $this->disabled || ('' === ($name = $this->getName()))) return false;

			if (null === ($value = Request::post($name))) return false;

            # Format value

            if ($this->type !== FORM_INPUT_PASSWORD) {

    			$this->value = String::input($value, false, $this->maxlength);

    			if ($this->translit) $this->value = String::translit($this->value, $this->maxlength);

            } else $this->value = strval($value);

            # Check for errors

            if ($this->required && ('' === $this->value)) $this->error = true;

			# ------------------------

			return ($this->posted = true);
		}

		# Get block

		public function block() {

            $name = (($this->type !== FORM_INPUT_TEXTAREA) ? 'input' : 'textarea');

			$tag = new Tag($name, $this->getAttributes(), $this->getContents());

			# ------------------------

			return $tag->block();
		}
	}
}
