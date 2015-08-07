<?php

namespace Form\Field {

	use Form\Utils, Request, Tag, Template, DOMDocument;

	class Select extends Utils\Field {

		private $options = array(), $search = false, $auto = false;

		# Get options

		private function getOptions() {

			$options = new DOMDocument('1.0', 'UTF-8');

			foreach ($this->options as $value => $text) {

				$options->appendChild($option = $options->createElement('option', $text));

				if (($this->value === $value)) $option->setAttribute('selected', 'selected');
			}

			# ------------------------

			return new Template\Utils\Block($options->saveHTML(), false);
		}

		# Constructor

		public function options(array $options, $default = '') {

			$default = (('' !== ($default = strval($default))) ? array('' => $default) : array());

			$this->options = array_merge($default, $options);
		}

		# Set search

		public function search($value) {

            $this->search = boolval($value);
        }

		# Set auto

		public function auto($value) {

            $this->auto = boolval($value);
        }

		# Catch POST value

		public function post() {

			if ($this->posted || $this->disabled || ('' === ($name = $this->getName()))) return false;

			if ((array() === $this->options) || (null === ($value = Request::post($name)))) return false;

			# Format value

			$key = array_search($value, ($range = array_keys($this->options)));

			$this->value = ((false !== $key) ? $range[$key] : key($this->options));

			# Check for errors

			if ($this->required && empty($this->value)) $this->error = true;

			# ------------------------

			return ($this->posted = true);
		}

		# Get block

		public function block() {

			$tag = new Tag('select', $this->getAttributes(), $this->getOptions());

			return $tag->block();
		}
	}
}
