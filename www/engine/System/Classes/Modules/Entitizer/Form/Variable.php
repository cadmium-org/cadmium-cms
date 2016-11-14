<?php

namespace Modules\Entitizer\Form {

	use Modules\Entitizer, Utils\Form;

	class Variable extends Form {

		protected $name = 'variable';

		# Constructor

		public function __construct(Entitizer\Entity\Variable $variable) {

			$this->addText('title', $variable->title, FORM_FIELD_TEXT, CONFIG_VARIABLE_TITLE_MAX_LENGTH, ['required' => true]);

			$this->addText('name', $variable->name, FORM_FIELD_TEXT, CONFIG_VARIABLE_NAME_MAX_LENGTH,

				['required' => true, 'convert' => 'var']);

			$this->addText('value', $variable->value, FORM_FIELD_TEXT, CONFIG_VARIABLE_VALUE_MAX_LENGTH);
		}
	}
}
