<?php

namespace Form\Field {

	use Form\Utils, Request, Tag;

	class Checkbox extends Utils\Field {

		# Get attributes

		private function getAttributes() {

			$attributes = array();

			# Set type

			$attributes['type'] = 'checkbox';

			# Set name/id

			$attributes['name'] = $this->getName();

			$attributes['id'] = $this->getId();

			# Set additional options

			if ($this->error) $attributes['data-error'] = 'error';

			if ($this->disabled) $attributes['disabled'] = 'disabled';

			# Set value

			if ($this->value) $attributes['checked'] = 'checked';

			# ------------------------

            return $attributes;
		}

		# Constructor

		public function __construct($form, $name, $value = false, $config = 0) {

			$this->setForm($form); $this->setName($name); $this->value = boolval($value);

			$this->setConfig($config);
		}

		# Catch POST value

		public function post() {

			if ($this->posted || $this->disabled || ('' === ($name = $this->getName()))) return false;

			$value = Request::post($name);

			# Format value

			$this->value = boolval($value);

			# Check for errors

			if ($this->required && (false === $this->value)) $this->error = true;

			# ------------------------

			return ($this->posted = true);
		}

		# Get block

		public function block() {

			$tag = new Tag('input', $this->getAttributes());

			return $tag->block();
		}
	}
}
