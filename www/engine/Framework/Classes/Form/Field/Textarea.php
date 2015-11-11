<?php

namespace Form\Field {

	use Form\Utils, Text;

	class Textarea extends Utils\Field {

		# Field default value

		protected $value = '';

		# Field data

		private $maxlength = 0, $rows = 0;

		# Field configuration

		protected $config = [

			'placeholder'       = '',
			'readonly'          = false,
			'autofocus'         = false,
			'translit'          = false
		];

		# Constructor

		public function __construct(Form $form, string $key, int $maxlength = 0, int $rows = 0, array $config = []) {

			self::init($form, $key, $config);

			$this->maxlength = $maxlength; $this->rows = $rows;
		}

		# Set value

		public function set(string $value) {

			$this->value = Text::input($value, true, $this->maxlength);

			if ($this->config['translit']) $this->value = Text::translit($this->value, $this->maxlength);

			# ------------------------

			return (!($this->required && ('' === $this->value)));
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

			$tag = $this->getTag('textarea', [], $this->value);

			# Set appearance

			if (0 < $this->maxlength) $tag->set('maxlength', $this->maxlength);

			if (0 < $this->rows) $tag->set('rows', $this->rows);

			if ('' !== $this->config['placeholder']) $tag->set('placeholder', $this->config['placeholder']);

			if ($this->config['readonly']) $tag->set('readonly', 'readonly');

			if ($this->config['autofocus']) $tag->set('autofocus', 'autofocus');

			# ------------------------

			return $tag->block();
		}
	}
}

