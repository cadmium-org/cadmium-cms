<?php

namespace Form\Field {

	use Form\Utils, Request, Tag, Template, Validate;

	class Checkbox extends Utils\Field {

		# Constructor

		public function __construct($form, $name, $value = false, $config = 0) {

			$this->setForm($form); $this->setName($name); $this->value = Validate::boolean($value);

			$this->setConfig($config);
		}

		# Catch POST value

		public function post() {

			if ($this->posted || $this->disabled || ('' === ($name = $this->getName()))) return false;

			if (null === ($value = Request::post($name))) return false;

			$this->value = Validate::boolean($value);

			if ($this->required && ('' === $this->value)) $this->error = true;

			# ------------------------

			return ($this->posted = true);
		}

		# Get block

		public function block() {

			$attributes = array();

			$block = new Template\Utils\Group();

			# Create hidden field

			$attributes['type'] = 'hidden';

			$attributes['name'] = $this->getName();

			$tag = new Tag('input', $attributes); $block->add($tag->block());

			# Create checkbox field

			$attributes['type'] = 'checkbox';

			$attributes['id'] = $this->getId();

			if ($this->error) $attributes['data-error'] = 'error';

			if ($this->readonly) $attributes['readonly'] = 'readonly';

			if ($this->disabled) $attributes['disabled'] = 'disabled';

			if ($this->value) $attributes['checked'] = 'checked';

			$tag = new Tag('input', $attributes); $block->add($tag->block());

			# ------------------------

			return $block;
		}
	}
}
