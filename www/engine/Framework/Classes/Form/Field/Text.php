<?php

/**
 * @package Framework\Form
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2016, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Form\Field {

	use Form, Str;

	class Text extends Form\Field {

		# Field default value

		protected $value = '';

		# Field data

		private $type = FORM_FIELD_TEXT, $maxlength = 0;

		# Field configuration

		protected $config = [

			'multiline'         => false,
			'codestyle'         => false,
			'spaces'            => '',
			'convert'           => '',
			'transform'         => '',

			'placeholder'       => '',
			'readonly'          => false,
			'autofocus'         => false,
			'rows'              => 0,
			'cols'              => 0
		];

		/**
		 * Get a hidden input tag
		 */

		private function getHidden() {

			return $this->getTag('input', '', ['type' => 'hidden', 'value' => $this->value]);
		}

		/**
		 * Get a password input tag
		 */

		private function getPassword() {

			return $this->getTag('input', '', ['type' => 'password', 'value' => '']);
		}

		/**
		 * Get a captcha input tag
		 */

		private function getCaptcha() {

			return $this->getTag('input', '', ['type' => 'text', 'value' => '']);
		}

		/**
		 * Get a text input tag
		 */

		private function getText() {

			return $this->getTag('input', '', ['type' => 'text', 'value' => $this->value]);
		}

		/**
		 * Get a textarea input tag
		 */

		private function getTextarea() {

			$tag = $this->getTag('textarea', $this->value);

			if ($this->rows > 0) $tag->setAttribute('rows', $this->rows);

			if ($this->cols > 0) $tag->setAttribute('cols', $this->cols);

			# ------------------------

			return $tag;
		}

		/**
		 * Process spaces
		 */

		private function processSpaces() {

			if ($this->spaces === 'strip') $this->value = Str::stripSpaces($this->value);

			else if ($this->spaces === 'single') $this->value = Str::singleSpaces($this->value);
		}

		/**
		 * Process convert
		 */

		private function processConvert() {

			if ($this->convert === 'url') $this->value = Str::toUrl($this->value, $this->maxlength);

			else if ($this->convert === 'var') $this->value = Str::toVar($this->value, $this->maxlength);
		}

		/**
		 * Process case transform
		 */

		private function processTransform() {

			if ($this->transform === 'lower') $this->value = Str::toLower($this->value);

			else if ($this->transform === 'upper') $this->value = Str::toUpper($this->value);
		}

		/**
		 * Constructor
		 */

		public function __construct(Form $form, string $key, string $value = '',

		    string $type = FORM_FIELD_TEXT, int $maxlength = 0, array $config = []) {

			# Init field

			self::init($form, $key, $config);

			# Set data

			$this->type = $type; $this->maxlength = $maxlength;

			# Set value

			$this->setValue($value);
		}

		/**
		 * Set a value
		 *
		 * @return true if the result value is not empty, otherwise false
		 */

		public function setValue(string $value) {

			if (($this->type === FORM_FIELD_PASSWORD) || ($this->type === FORM_FIELD_CAPTCHA)) {

				$this->value = Str::substr($value, 0, $this->maxlength);

			} else {

				$multiline = (($this->type === FORM_FIELD_TEXTAREA) && $this->multiline);

				$codestyle = (($this->type === FORM_FIELD_TEXTAREA) && $this->codestyle);

				$this->value = Str::formatInput($value, $this->maxlength, $multiline, $codestyle);

				# Process operations

				$this->processSpaces(); $this->processConvert(); $this->processTransform();
			}

			# ------------------------

			return ('' !== $this->value);
		}

		/**
		 * Get a block
		 */

		public function getBlock() {

			# Process hidden field

			if ($this->type === FORM_FIELD_HIDDEN) return $this->toBlock($this->getHidden());

			# Process visible field

			else if ($this->type === FORM_FIELD_PASSWORD) $tag = $this->getPassword();

			else if ($this->type === FORM_FIELD_CAPTCHA) $tag = $this->getCaptcha();

			else if ($this->type === FORM_FIELD_TEXTAREA) $tag = $this->getTextarea();

			else $tag = $this->getText();

			# Set appearance

			if ($this->maxlength > 0) $tag->setAttribute('maxlength', $this->maxlength);

			if ('' !== $this->placeholder) $tag->setAttribute('placeholder', $this->placeholder);

			if ($this->readonly) $tag->setAttribute('readonly', 'readonly');

			if ($this->autofocus) $tag->setAttribute('autofocus', 'autofocus');

			# ------------------------

			return $this->toBlock($tag);
		}
	}
}
