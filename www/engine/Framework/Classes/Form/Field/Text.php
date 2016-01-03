<?php

namespace Form\Field {

	use Form, Form\Utils, Str;

	class Text extends Utils\Field {

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

		# Get hidden input tag

		private function getHidden() {

			return $this->getTag('input', ['type' => 'hidden', 'value' => $this->value]);
		}

		# Get password input tag

		private function getPassword() {

			return $this->getTag('input', ['type' => 'password', 'value' => '']);
		}

		# Get captcha input tag

		private function getCaptcha() {

			return $this->getTag('input', ['type' => 'text', 'value' => '']);
		}

		# Get text input tag

		private function getText() {

			return $this->getTag('input', ['type' => 'text', 'value' => $this->value]);
		}

		# Get textarea tag

		private function getTextarea() {

			$tag = $this->getTag('textarea', [], $this->value);

			if ($this->config['rows'] > 0) $tag->set('rows', $this->config['rows']);

			if ($this->config['cols'] > 0) $tag->set('cols', $this->config['cols']);

			# ------------------------

			return $tag;
		}

		# Process spaces

		private function processSpaces() {

			if ($this->config['spaces'] === 'strip') $this->value = Str::stripSpaces($this->value);

			else if ($this->config['spaces'] === 'single') $this->value = Str::singleSpaces($this->value);
		}

		# Process convert

		private function processConvert() {

			if ($this->config['convert'] === 'url') $this->value = Str::toUrl($this->value, $this->maxlength);

			else if ($this->config['convert'] === 'var') $this->value = Str::toVar($this->value, $this->maxlength);
		}

		# Process transform

		private function processTransform() {

			if ($this->config['transform'] === 'lower') $this->value = Str::toLower($this->value);

			else if ($this->config['transform'] === 'upper') $this->value = Str::toUpper($this->value);
		}

		# Constructor

		public function __construct(Form $form, string $key, string $value = '',

		    string $type = FORM_FIELD_TEXT, int $maxlength = 0, array $config = []) {

			# Init field

			self::init($form, $key, $config);

			# Set data

			$this->type = $type; $this->maxlength = $maxlength;

			# Set value

			$this->set($value);
		}

		# Set value

		public function set(string $value) {

			if (($this->type === FORM_FIELD_PASSWORD) || ($this->type === FORM_FIELD_CAPTCHA)) {

				$this->value = Str::substr($value, 0, $this->maxlength);

			} else {

				$multiline = (($this->type === FORM_FIELD_TEXTAREA) && $this->config['multiline']);

				$codestyle = (($this->type === FORM_FIELD_TEXTAREA) && $this->config['codestyle']);

				$this->value = Str::input($value, $this->maxlength, $multiline, $codestyle);

				# Process operations

				$this->processSpaces(); $this->processConvert(); $this->processTransform();
			}

			# ------------------------

			return ('' !== $this->value);
		}

		# Set multiline

		public function multiline(bool $value) {

			$this->config['multiline'] = $value;
		}

		# Set codestyle

		public function codestyle(bool $value) {

			$this->config['codestyle'] = $value;
		}

		# Set spaces

		public function spaces(string $value) {

			if (!in_array($value, ['strip', 'single'], true)) $value = '';

			$this->config['spaces'] = $value;
		}

		# Set convert

		public function convert(string $value) {

			if (!in_array($value, ['url', 'var'], true)) $value = '';

			$this->config['convert'] = $value;
		}

		# Set transform

		public function transform(string $value) {

			if (!in_array($value, ['upper', 'lower'], true)) $value = '';

			$this->config['transform'] = $value;
		}

		# Set placeholder

		public function placeholder(string $value) {

			$this->config['placeholder'] = $value;
		}

		# Set readonly

		public function readonly(bool $value) {

			$this->config['readonly'] = $value;
		}

		# Set autofocus

		public function autofocus(bool $value) {

			$this->config['autofocus'] = $value;
		}

		# Set rows

		public function rows(int $value) {

			$this->config['rows'] = $value;
		}

		# Set cols

		public function cols(int $value) {

			$this->config['cols'] = $value;
		}

		# Get block

		public function block() {

			if ($this->type === FORM_FIELD_HIDDEN) return $this->getHidden()->block();

			else if ($this->type === FORM_FIELD_PASSWORD) $tag = $this->getPassword();

			else if ($this->type === FORM_FIELD_CAPTCHA) $tag = $this->getCaptcha();

			else if ($this->type === FORM_FIELD_TEXTAREA) $tag = $this->getTextarea();

			else $tag = $this->getText();

			# Set appearance

			if ($this->maxlength > 0) $tag->set('maxlength', $this->maxlength);

			if ('' !== $this->config['placeholder']) $tag->set('placeholder', $this->config['placeholder']);

			if ($this->config['readonly']) $tag->set('readonly', 'readonly');

			if ($this->config['autofocus']) $tag->set('autofocus', 'autofocus');

			# ------------------------

			return $tag->block();
		}
	}
}
