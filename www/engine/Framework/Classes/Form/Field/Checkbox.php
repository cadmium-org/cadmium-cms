<?php

namespace Form\Field {

	use Form\Utils, Request, Tag;

	class Checkbox extends Utils\Field {

		# Get attributes

		protected function getAttributes() {

			$attributes = parent::getAttributes();

			$attributes['type'] = 'checkbox';

			if ($this->value) $attributes['checked'] = 'checked';

			# ------------------------

            return $attributes;
		}

		# Catch POST value

		public function post() {

			if ($this->posted || $this->disabled || ('' === ($name = $this->getName()))) return false;

			$value = Request::post($name);

			# Format value

			$this->value = strval($value);

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
