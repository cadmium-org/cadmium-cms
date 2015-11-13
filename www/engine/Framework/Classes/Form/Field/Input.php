<?php

namespace Form\Field {

	use Form\Utils, Text;

	class Input extends Utils\Field {

		# Field default value

		protected $value = '';

		# Field data

		private $type = FORM_INPUT_TEXT, $maxlength = 0;

		# Field configuration

		protected $config = [

			'placeholder'       = '',
			'readonly'          = false,
			'autofocus'         = false,
			'translit'          = false
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

		# Constructor

		public function __construct(Form $form, string $key, string $type = FORM_INPUT_TEXT, int $maxlength = 0, array $config = []) {

			self::init($form, $key, $config);

			$this->type = $type; $this->maxlength = $maxlength;
		}

		# Set value

		public function set(string $value) {

			if ($this->type === FORM_INPUT_PASSWORD) {

				$this->value = Text::cut($value, $this->maxlength);

			} else {

				$this->value = Text::input($value, false, $this->maxlength);

				if ($this->config['translit']) $this->value = Text::translit($this->value, $this->maxlength);
			}

			# Check for errors

			if ($this->required && ('' === $this->value)) return 'required';

			# ------------------------

			return true;
		}

		# Set placeholder

		public function placeholder(string $value = null) {

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

		# Set translit

		public function translit(bool $value) {

			$this->config['translit'] = $value;
		}

		# Get block

		public function block() {

			if ($this->type === FORM_INPUT_HIDDEN) {

				$tag = $this->getHidden();

			} else {

				if ($this->type === FORM_INPUT_PASSWORD) $tag = $this->getPassword();

				else if ($this->type === FORM_INPUT_CAPTCHA) $tag = $this->getCaptcha();

				else $tag = $this->getText();

				# Set appearance

				if (0 < $this->maxlength) $tag->set('maxlength', $this->maxlength);

				if ('' !== $this->config['placeholder']) $tag->set('placeholder', $this->config['placeholder']);

				if ($this->config['readonly']) $tag->set('readonly', 'readonly');

				if ($this->config['autofocus']) $tag->set('autofocus', 'autofocus');
			}

			# ------------------------

			return $tag->block();
		}
	}
}
