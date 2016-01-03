<?php

namespace System\Modules\Entitizer\Form {

	use System\Modules\Entitizer, System\Utils\Form;

	class Variable extends Form {

		# Constructor

		public function __construct(Entitizer\Entity\Variable $variable) {

			parent::__construct(ENTITY_TYPE_VARIABLE);

			# Add fields

			$this->addText('title', $variable->title, FORM_FIELD_TEXT, CONFIG_VARIABLE_TITLE_MAX_LENGTH, ['required' => true]);

			$this->addText('name', $variable->name, FORM_FIELD_TEXT, CONFIG_VARIABLE_NAME_MAX_LENGTH,

				['required' => true, 'convert' => 'var']);

			$this->addText('value', $variable->value, FORM_FIELD_TEXT, CONFIG_VARIABLE_VALUE_MAX_LENGTH);
		}
	}
}
