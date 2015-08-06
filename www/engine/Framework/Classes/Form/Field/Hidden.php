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

			# Format value

			$this->value = strval($value);

			# ------------------------

			return ($this->posted = true);
		}

		# Get block

		public function block() {

			$attributes = array();

			# Set type

			$attributes['type'] = 'hidden';

			# Set initial data

			$attributes['name'] = $this->getName();

			$attributes['id'] = $this->getId();

			# Set value

			$attributes['value'] = $this->value;

			# Create tag

			$tag = new Tag('input', $attributes); $block = $tag->block();

			# ------------------------

			return $block;
		}
	}
}
