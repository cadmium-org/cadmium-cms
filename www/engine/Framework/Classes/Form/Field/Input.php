<?php

namespace Form\Field {

	use Form\Utils, Request, String, Tag;

	class Input extends Utils\Field {

		private $type = '', $maxlength = 0, $rows = 0, $placeholder = '';

        # Get type

        private function getType() {

            if ($this->type === FORM_INPUT_TYPE_TEXTAREA) return false;

            $type = (($this->type !== FORM_INPUT_TYPE_PASSWORD) ? 'text' : 'password');

            # ------------------------

            return $type;
        }

        # Get value

        private function getValue() {

            if ($this->type === FORM_INPUT_TYPE_TEXTAREA) return false;

            $value = (!in_array($this->type, array(FORM_INPUT_TYPE_PASSWORD, FORM_INPUT_TYPE_CAPTCHA)) ? $this->value : '');

            # ------------------------

            return $value;
        }

        # Get attributes

        private function getAttributes() {

            $attributes = array();

            # Set type

            if (false !== ($type = $this->getType())) $attributes['type'] = $type;

            # Set initial data

			$attributes['name'] = $this->getName();

            $attributes['id'] = $this->getId();

            # Set appearance

			if (0 !== $this->maxlength) $attributes['maxlength'] = $this->maxlength;

			if ('' !== $this->placeholder) $attributes['placeholder'] = $this->placeholder;

            # Set additional options

			if ($this->error) $attributes['data-error'] = 'error';

			if ($this->readonly) $attributes['readonly'] = 'readonly';

			if ($this->disabled) $attributes['disabled'] = 'disabled';

            # Set value

            if (false !== ($value = $this->getValue())) $attributes['value'] = $value;

            # ------------------------

            return $attributes;
        }

        # Get contents

        private function getContents() {

            return (($this->type === FORM_INPUT_TYPE_TEXTAREA) ? $this->value : null);
        }

		# Constructor

		public function __construct($form, $name, $value = '', $type = '', $maxlength = 0, $rows = 0, $placeholder = '', $config = 0) {

			$this->setForm($form); $this->setName($name); $this->value = strval($value);

			$this->type = strval($type); $this->maxlength = intabs($maxlength); $this->rows = intabs($rows);

            $this->placeholder = strval($placeholder);

			$this->setConfig($config);
		}

		# Catch POST value

		public function post() {

			if ($this->posted || $this->disabled || ('' === ($name = $this->getName()))) return false;

			if (null === ($value = Request::post($name))) return false;

            # Format value

            if ($this->type !== FORM_INPUT_TYPE_PASSWORD) {

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

            $name = (($this->type !== FORM_INPUT_TYPE_TEXTAREA) ? 'input' : 'textarea');

			$tag = new Tag($name, $this->getAttributes(), $this->getContents());

			# ------------------------

			return $tag->block();;
		}
	}
}
