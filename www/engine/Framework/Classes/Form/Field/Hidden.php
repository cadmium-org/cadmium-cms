<?php

namespace Form\Field {

	use Form, Form\Utils, Request, String, Tag;

	class Hidden extends Utils\Field {

		# Constructor

		public function __construct($form, $name, $value = false) {

			if ($form instanceof Form) $this->form = $form;

			$this->name = $this->validateName($name); $this->value = String::validate($value);
		}

		# Catch POST value

		public function post() {

			if ($this->posted || (false === ($name = $this->getName()))) return false;

			if (null === ($value = Request::post($name))) return false;

			$this->value = $value;

			# ------------------------

			return ($this->posted = true);
		}

		# Get block

		public function block() {

			$attributes['type'] = 'hidden';

			$attributes['name'] = $this->getName(); $attributes['id'] = $this->getId();

			$attributes['value'] = $this->value;

			$tag = new Tag('input', $attributes); $block = $tag->block();

			# ------------------------

			return $block;
		}
	}
}

?>
