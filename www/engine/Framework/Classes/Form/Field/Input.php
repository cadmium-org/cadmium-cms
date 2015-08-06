<?php

namespace Form\Field {

	use Form\Utils, Request, String, Tag;

	class Input extends Utils\Field {

		private $type = '', $maxlength = 0, $placeholder = '';

		# Constructor

		public function __construct($form, $name, $value = '', $type = '', $maxlength = 0, $placeholder = '', $config = 0) {

			$this->setForm($form); $this->setName($name); $this->value = strval($value);

			$this->type = strval($type); $this->maxlength = intabs($maxlength); $this->placeholder = strval($placeholder);

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

			$attributes = array();

            # Set type

			$attributes['type'] = (($this->type !== FORM_INPUT_TYPE_PASSWORD) ? 'text' : 'password');

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

            $reset = (($this->type === FORM_INPUT_TYPE_PASSWORD) || ($this->type === FORM_INPUT_TYPE_CAPTCHA));

			$attributes['value'] = (!$reset ? $this->value : '');

            # Create tag

			$tag = new Tag('input', $attributes); $block = $tag->block();

			# ------------------------

			return $block;
		}
	}
}
