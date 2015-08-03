<?php

namespace Form\Field {

	use Form\Utils, Request, Tag;

	class Password extends Utils\Field {

		private $maxlength = 0, $placeholder = '';

		# Constructor

		public function __construct($form, $name, $value = '', $maxlength = 0, $placeholder = '', $config = 0) {

			$this->setForm($form); $this->setName($name); $this->value = strval($value);

			$this->maxlength = intabs($maxlength); $this->placeholder = strval($placeholder);

			$this->setConfig($config);
		}

		# Catch POST value

		public function post() {

			if ($this->posted || $this->disabled || ('' === ($name = $this->getName()))) return false;

			if (null === ($value = Request::post($name))) return false;

			$this->value = strval($value);

			if ($this->required && ('' === $this->value)) $this->error = true;

			# ------------------------

			return ($this->posted = true);
		}

		# Get block

		public function block() {

			$attributes = array();

			$attributes['type'] = 'password';

			$attributes['name'] = $this->getName();

			$attributes['id'] = $this->getId();

			if (0 !== $this->maxlength) $attributes['maxlength'] = $this->maxlength;

			if ('' !== $this->placeholder) $attributes['placeholder'] = $this->placeholder;

			if ($this->error) $attributes['data-error'] = 'error';

			if ($this->readonly) $attributes['readonly'] = 'readonly';

			if ($this->disabled) $attributes['disabled'] = 'disabled';

			$attributes['value'] = false;

			$tag = new Tag('input', $attributes); $block = $tag->block();

			# ------------------------

			return $block;
		}
	}
}
