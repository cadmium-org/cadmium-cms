<?php

namespace Form\Field {

	use Form, Form\Utils, Arr, String, Request, Tag, Template, Validate;

	class Select extends Utils\Field {

		private $options = false;

		# Constructor

		public function __construct($form, $name, $value, $options, $default = false, $config = false) {

			if ($form instanceof Form) $this->form = $form;

			$this->name = $this->validateName($name); $this->value = String::validate($value);

			$default = ((false !== ($default = String::validate($default))) ? array('' => $default) : array());

			$this->options = array_merge($default, Arr::force($options));

			$this->setConfig($config);
		}

		# Catch POST value

		public function post() {

			if ($this->posted || $this->disabled || (false === ($name = $this->getName()))) return false;

			if (array() === $this->options) return false;

			if (null === ($value = Request::post($name))) return false;

			$key = array_search($value, ($range = array_keys($this->options)));

			$this->value = ((false !== $key) ? $range[$key] : key($this->options));

			if ($this->required && !$this->value) $this->error = true;

			# ------------------------

			return ($this->posted = true);
		}

		# Get block

		public function block() {

			$attributes = array();

			$attributes['name'] = $this->getName();

			$attributes['id'] = $this->getId();

			if ($this->error) $attributes['data-error'] = 'error';

			if ($this->disabled) $attributes['disabled'] = 'disabled';

			if ($this->search) $attributes['data-search'] = 'search';

			if ($this->auto) $attributes['data-auto'] = 'auto';

			$options = new Template\Utils\Group();

			foreach ($this->options as $value => $text) {

				$value = String::validate($value); $text = String::validate($text);

				$attributes_o = array('value' => $value);

				if ($this->value === $value) $attributes_o['selected'] = 'selected';

				$option = new Tag('option', $attributes_o, $text);

				$options->add($option->block());
			}

			$tag = new Tag('select', $attributes, $options); $block = $tag->block();

			# ------------------------

			return $block;
		}
	}
}
