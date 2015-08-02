<?php

namespace Form\Field {

	use Form\Utils, Request, Tag;

	class Hidden extends Utils\Field {

		# Constructor

		public function __construct($form, $name, $value = '') {

			$this->setForm($form); $this->setName($name); $this->value = strval($value);
		}

		# Catch POST value

		public function post() {

			if ($this->posted || ('' === ($name = $this->getName()))) return false;

			if (null === ($value = Request::post($name))) return false;

			$this->value = $value;

			# ------------------------

			return ($this->posted = true);
		}

		# Get block

		public function block() {

			$attributes = array();

			$attributes['type'] = 'hidden';

			$attributes['name'] = $this->getName();

			$attributes['id'] = $this->getId();

			$attributes['value'] = $this->value;

			$tag = new Tag('input', $attributes); $block = $tag->block();

			# ------------------------

			return $block;
		}
	}
}
