<?php

namespace Form\Field {

	use Form\Utils, Form\View;

	class Select extends Utils\Implementable {

		private $options = [], $search = false, $auto = false;

		# Get options

		private function getOptions() {

			$options = [];

			foreach ($this->options as $value => $text) {

				$selected = (($this->value === $value) ? ' selected' : '');

				$options[] = ['value' => $value, 'selected' => $selected, 'text' => $text];
			}

			$block = new View\Options();

			$block->options = $options;

			# ------------------------

			return $block;
		}

		# Constructor

		public function __construct($form, $name, $value, array $options, $default = null) {

			parent::__construct($form, $name);

			$default = ((null !== $default) ? ['' => strval($default)] : []);

			$this->options = array_merge($default, $options);

			$this->set($value);
		}

		# Set value

		public function set($value) {

			$this->value = strval($value);

			$key = array_search($this->value, ($range = array_keys($this->options)));

			$this->value = ((false !== $key) ? $range[$key] : key($this->options));

			# ------------------------

			return (!($this->required && empty($this->value)));
		}

		# Set search

		public function search($value) {

			$this->search = boolval($value);
		}

		# Set auto

		public function auto($value) {

			$this->auto = boolval($value);
		}

		# Get block

		public function block() {

			$tag = $this->getTag('select');

			if ($this->search) $tag->set('data-search', 'search');

			if ($this->auto) $tag->set('data-auto', 'auto');

			$tag->contents($this->getOptions());

			# ------------------------

			return $tag->block();
		}
	}
}
