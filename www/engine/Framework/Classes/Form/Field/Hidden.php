<?php

namespace Form\Field {

	use Form\Utils, Request, Tag;

	class Hidden extends Utils\Field {

		# Get attributes

		protected function getAttributes() {

			$attributes = parent::getAttributes();

			$attributes['type'] = 'hidden';

			$attributes['value'] = $this->value;

			# ------------------------

            return $attributes;
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
