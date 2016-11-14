<?php

/**
 * @package Framework\Form
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2016, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Form\Field {

	use Form, Tag;

	class Select extends Form\Field {

		# Field default value

		protected $value = '';

		# Field data

		private $options = [];

		# Field configuration

		protected $config = [

			'search'            => false,
			'auto'              => false
		];

		/**
		 * Constructor
		 */

		public function __construct(Form $form, string $key, string $value = '',

		    array $options = [], string $default = null, array $config = []) {

			# Init field

			self::init($form, $key, $config);

			# Set data

			$this->options = array_merge(((null !== $default) ? ['' => $default] : []), $options);

			# Set value

			$this->setValue($value);
		}

		/**
		 * Set a value
		 *
		 * @return true if the result value is not empty, otherwise false
		 */

		public function setValue(string $value) {

			$key = array_search($value, ($range = array_keys($this->options)));

			$this->value = ((false !== $key) ? $range[$key] : key($this->options));

			# ------------------------

			return !empty($this->value);
		}

		/**
		 * Get a block
		 */

		public function getBlock() {

			$tag = $this->getTag('select');

			# Set appearance

			if ($this->search) $tag->setAttribute('data-search', 'search');

			if ($this->auto) $tag->setAttribute('data-auto', 'auto');

			# Set options

			foreach ($this->options as $value => $text) {

				if (!is_scalar($text)) continue;

				$tag->appendChild($option = Tag::create('option', $text));

				$option->setAttribute('value', $value);

				if ($this->value === $value) $option->setAttribute('selected', null);
			}

			# ------------------------

			return $this->toBlock($tag);
		}
	}
}
