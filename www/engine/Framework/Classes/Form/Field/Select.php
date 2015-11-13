<?php

namespace Form\Field {

	use Form\Utils, Form\View;

	class Select extends Utils\Field {

		# Field default value

		protected $value = '';

		# Field data

		private $options = [];

		# Field configuration

		protected $config = [

			'search'            = false,
			'auto'              = false
		];

		# Get options

		private function getOptions() {

			$block = new View\Options(); $options = $block->loop('options');

			foreach ($this->options as $value => $text) {

				$selected = (($this->value === $value) ? ' selected' : '');

				$options->add(['value' => $value, 'selected' => $selected, 'text' => $text]);
			}

			# ------------------------

			return $block;
		}

		# Constructor

		public function __construct(Form $form, $string $key, array $options = [], string $default = null) {

			self::init($form, $key, $config);

			$this->options = array_merge(((null !== $default) ? ['' => $default] : []), $options);
		}

		# Set value

		public function set(string $value) {

			$key = array_search($value, ($range = array_keys($this->options)));

			$this->value = ((false !== $key) ? $range[$key] : key($this->options));

			# Check for errors

			if ($this->required && empty($this->value)) return 'required';

			# ------------------------

			return true;
		}

		# Set search

		public function search(bool $value) {

			$this->config['search'] = $value;
		}

		# Set auto

		public function auto(bool $value) {

			$this->config['auto'] = $value;
		}

		# Get block

		public function block() {

			$tag = $this->getTag('select');

			if ($this->config['search']) $tag->set('data-search', 'search');

			if ($this->config['auto']) $tag->set('data-auto', 'auto');

			$tag->contents($this->getOptions());

			# ------------------------

			return $tag->block();
		}
	}
}
