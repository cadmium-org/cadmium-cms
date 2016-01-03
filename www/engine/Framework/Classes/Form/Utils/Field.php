<?php

namespace Form\Utils {

	use Form, Request, Tag;

	abstract class Field {

		private $form = null, $posted = false;

		protected $key = '', $name = '', $value = null;

		protected $disabled = false, $required = false, $config = [], $error = false;

		# Get tag

		protected function getTag(string $name, array $attributes = [], $contents = null) {

			$tag = new Tag($name, $attributes, $contents);

			$tag->set('name', $this->name);

			$tag->set('id', str_replace('_', '-', $this->name));

			# Set config

			if ($this->disabled) $tag->set('disabled', 'disabled');

			if ($this->required) $tag->set('data-required', 'required');

			if ($this->error) $tag->set('data-error', 'error');

			# ------------------------

			return $tag;
		}

		# Init field

		protected function init(Form $form, string $key, array $config = []) {

			$this->form = $form;

			# Set key & name

			if (preg_match(REGEX_FORM_FIELD_KEY, $key)) {

				$prefix = (('' !== $this->form->name()) ? ($this->form->name() . '_') : '');

				$this->key = $key; $this->name = ($prefix . $key);
			}

			# Set params

			$params = array_merge(['disabled' => false, 'required' => false], $this->config);

			foreach ($params as $name => $default) if (isset($config[$name])) {

				$checker = ((0 === $default) ? 'is_numeric' : 'is_scalar');

				if ($checker($config[$name])) $this->$name($config[$name]);
			}
		}

		# Post value

		public function post() {

			if ($this->posted || $this->disabled || ('' === $this->key)) return false;

			$this->error = (!$this->set(Request::post($this->name)) && $this->required);

			# ------------------------

			return ($this->posted = true);
		}

		# Return key

		public function key() {

			return $this->key;
		}

		# Return name

		public function name() {

			return $this->name;
		}

		# Return value

		public function value() {

			return $this->value;
		}

		# Set/check if field is disabled

		public function disabled(bool $value = null) {

			if (null === $value) return $this->disabled;

			$this->disabled = $value;
		}

		# Set/check if field is required

		public function required(bool $value = null) {

			if (null === $value) return $this->required;

			$this->required = $value;
		}

		# Check for error

		public function error() {

			return $this->error;
		}

		# Set value interface

		abstract public function set(string $value);

		# Get block interface

		abstract public function block();
	}
}
