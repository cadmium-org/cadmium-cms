<?php

namespace Form\Field {

	use Form\Utils, Request, Tag, Template;

	class Select extends Utils\Field {

		private $options = array();

		# Get attributes

		private function getAttributes() {

			$attributes = array();

			# Set initial data

			$attributes['name'] = $this->getName();

			$attributes['id'] = $this->getId();

			# Set additional options

			if ($this->error) $attributes['data-error'] = 'error';

			if ($this->disabled) $attributes['disabled'] = 'disabled';

			if ($this->search) $attributes['data-search'] = 'search';

			if ($this->auto) $attributes['data-auto'] = 'auto';

			# ------------------------

            return $attributes;
		}

		# Get options

		private function getOptions() {

			$options = '';

			foreach ($this->options as $value => $text) $options .= ('<option value="' . $value . '"' .

				(($this->value === $value) ? ' selected="selected"' : '') . '>' . $text . '</option>');

			# ------------------------

			return new Template\Utils\Block($options);
		}

		# Constructor

		public function __construct($form, $name, $value, array $options, $default = '', $config = 0) {

			$this->setForm($form); $this->setName($name); $this->value = strval($value);

			$default = (('' !== ($default = strval($default))) ? array('' => $default) : array());

			$this->options = array_merge($default, $options);

			$this->setConfig($config);
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
