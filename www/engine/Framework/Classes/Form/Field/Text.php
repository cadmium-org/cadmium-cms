<?php

namespace Form\Field {

	use Form, Form\Utils, Number, Request, String, Tag;

	class Text extends Utils\Field {

		private $maxlength = false, $placeholder = false;

		# Constructor

		public function __construct($form, $name, $value = false, $maxlength = 0, $placeholder = false, $config = false) {

			if ($form instanceof Form) $this->form = $form;

			$this->name = $this->validateName($name); $this->value = String::validate($value);

			$this->maxlength = Number::unsigned($maxlength); $this->placeholder = String::validate($placeholder);

			$this->setConfig($config);
		}

		# Catch POST value

		public function post() {

			if ($this->posted || $this->disabled || (false === ($name = $this->getName()))) return false;

			if (null === ($value = Request::post($name))) return false;

			$value = String::input($value, false, $this->maxlength);

			$this->value = ($this->translit ? String::translit($value) : $value);

			# ------------------------

			return ($this->posted = true);
		}

		# Get block

		public function block() {

			$attributes['type'] = 'text';

			$attributes['name'] = $this->getName(); $attributes['id'] = $this->getId();

			if (0 !== $this->maxlength) $attributes['maxlength'] = $this->maxlength;

			if (false !== $this->placeholder) $attributes['placeholder'] = $this->placeholder;

			if ($this->error) $attributes['data-error'] = 'error';

			if ($this->readonly) $attributes['readonly'] = 'readonly';

			if ($this->disabled) $attributes['disabled'] = 'disabled';

			$attributes['value'] = $this->value;

			$tag = new Tag('input', $attributes); $block = $tag->block();

			# ------------------------

			return $block;
		}
	}
}

?>
