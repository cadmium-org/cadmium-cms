<?php

/**
 * @package Cadmium\Framework\Form
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Form\Field {

	use Form, Template, Validate;

	class Checkbox extends Form\Field {

		# Field default value

		protected $value = false;

		/**
		 * Constructor
		 */

		public function __construct(Form $form, string $key, string $value = '') {

			# Init field

			self::init($form, $key);

			# Set value

			$this->setValue($value);
		}

		/**
		 * Set a value
		 *
		 * @return bool : the result value
		 */

		public function setValue(string $value) : bool {

			return ($this->value = Validate::boolean($value));
		}

		/**
		 * Get a block
		 */

		public function getBlock() : Template\Block {

			$tag = $this->getTag('input');

			$tag->setAttribute('type', 'checkbox');

			if ($this->value) $tag->setAttribute('checked', 'checked');

			# ------------------------

			return $tag->getBlock();
		}
	}
}
