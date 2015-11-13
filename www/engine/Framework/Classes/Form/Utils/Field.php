<?php

namespace Form\Utils {

	use Form, Request, Tag;

	class Field {

		private $form = null, $posted = false;

		protected $key = '', $name = '', $value = null;

		protected $disabled = false, $required = false, $error = null;

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

		# Validate form

		public function init(Form $form, string $key, array $config = []) {

			$this->form = $form;

			# Set field key & name

			if (preg_match(REGEX_FORM_FIELD_KEY, $key)) {

				$prefix = ((null !== $this->form) ? ($this->form->name() . '_') : '');

				$this->key = $key; $this->name = ($prefix . $key);
			}

			# Set field params

			$params = array_merge(['disabled', 'required'], array_keys(isset($this->config) ? $this->config : []));

			foreach ($params as $name) if (isset($config[$name])) call_user_method($name, $this, $config[$name]);
		}

		# Post value

		public function post() {

			if ($this->posted || $this->disabled || ('' === $this->key)) return false;

			$this->error = ((true !== ($result = $this->set(Request::post($this->name)))) ? $result : null);

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

		# Check if error

		public function error() {

			return ((null !== $this->error) ? $this->error : false);
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
	}
}
