<?php

namespace Form\Field {

	use Form\Utils, Request, Tag;

	class Hidden extends Utils\Field {

		# Get attributes

		private function getAttributes() {

			$attributes = array();

			# Set type

			$attributes['type'] = 'hidden';

			# Set name/id

			$attributes['name'] = $this->getName();

			$attributes['id'] = $this->getId();

			# Set additional options

			if ($this->disabled) $attributes['disabled'] = 'disabled';

			# Set value

			$attributes['value'] = $this->value;

			# ------------------------

            return $attributes;
		}

		# Constructor

		public function __construct($form, $name, $value = '') {

			$this->setForm($form); $this->setName($name); $this->value = strval($value);

			$this->setConfig($config);
		}

		# Catch POST value

		public function post() {

			if ($this->posted || $this->disabled || ('' === ($name = $this->getName()))) return false;

			if (null === ($value = Request::post($name))) return false;

			# Format value

			$this->value = strval($value);

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
