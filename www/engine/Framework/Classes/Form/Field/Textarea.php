<?php

namespace Form\Field {

	use Form\Utils, Request, String, Tag;

	class Textarea extends Utils\Field {

		private $maxlength = 0, $rows = 0, $placeholder = '';

		# Constructor

		public function __construct($form, $name, $value = '', $maxlength = 0, $rows = 0, $placeholder = '', $config = 0) {

			$this->setForm($form); $this->setName($name); $this->value = strval($value);

			$this->maxlength = intabs($maxlength); $this->rows = intabs($rows); $this->placeholder = strval($placeholder);

			$this->setConfig($config);
		}

		# Catch POST value

		public function post() {

			if ($this->posted || $this->disabled || ('' === ($name = $this->getName()))) return false;

			if (null === ($value = Request::post($name))) return false;

			# Format value

			$this->value = String::input($value, true, $this->maxlength);

			if ($this->translit) $this->value = String::translit($this->value, $this->maxlength);

			# Check for errors

			if ($this->required && ('' === $this->value)) $this->error = true;

			# ------------------------

			return ($this->posted = true);
		}

		# Get block

		public function block() {

			$attributes = array();

			# Set initial data

			$attributes['name'] = $this->getName();

			$attributes['id'] = $this->getId();

			# Set appearance

			if (0 !== $this->maxlength) $attributes['maxlength'] = $this->maxlength;

			if (0 !== $this->rows) $attributes['rows'] = $this->rows;

			if ('' !== $this->placeholder) $attributes['placeholder'] = $this->placeholder;

			# Set additional options

			if ($this->error) $attributes['data-error'] = 'error';

			if ($this->readonly) $attributes['readonly'] = 'readonly';

			if ($this->disabled) $attributes['disabled'] = 'disabled';

			# Create tag

			$tag = new Tag('textarea', $attributes, $this->value); $block = $tag->block();

			# ------------------------

			return $block;
		}
	}
}
