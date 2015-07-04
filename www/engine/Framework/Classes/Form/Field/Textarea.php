<?php

namespace Form\Field {

	use Form, Form\Utils, Number, Request, String, Tag;

	class Textarea extends Utils\Field {

		private $maxlength = false, $rows = false, $placeholder = false;

		# Constructor

		public function __construct($form, $name, $value = false, $maxlength = 0, $rows = 0, $placeholder = false, $config = false) {

			if ($form instanceof Form) $this->form = $form;

			$this->name = $this->validateName($name); $this->value = String::validate($value);

			$this->maxlength = Number::unsigned($maxlength); $this->rows = Number::unsigned($rows);

			$this->placeholder = String::validate($placeholder);

			$this->setConfig($config);
		}

		# Catch POST value

		public function post() {

			if ($this->posted || $this->disabled || (false === ($name = $this->getName()))) return false;

			if (null === ($value = Request::post($name))) return false;

			$this->value = String::input($value, true, $this->maxlength);

			# ------------------------

			return ($this->posted = true);
		}

		# Get block

		public function block() {

			$attributes['name'] = $this->getName(); $attributes['id'] = $this->getId();

			if (0 !== $this->maxlength) $attributes['maxlength'] = $this->maxlength;

			if (0 !== $this->rows) $attributes['rows'] = $this->rows;

			if (false !== $this->placeholder) $attributes['placeholder'] = $this->placeholder;

			if ($this->error) $attributes['data-error'] = 'error';

			if ($this->readonly) $attributes['readonly'] = 'readonly';

			if ($this->disabled) $attributes['disabled'] = 'disabled';

			$tag = new Tag('textarea', $attributes, $this->value); $block = $tag->block();

			# ------------------------

			return $block;
		}
	}
}

?>
