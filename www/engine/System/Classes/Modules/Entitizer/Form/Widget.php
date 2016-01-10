<?php

namespace Modules\Entitizer\Form {

	use Modules\Entitizer, Utils\Form;

	class Widget extends Form {

		# Constructor

		public function __construct(Entitizer\Entity\Widget $widget) {

			parent::__construct(ENTITY_TYPE_WIDGET);

			# Add fields

			$this->addText('title', $widget->title, FORM_FIELD_TEXT, CONFIG_WIDGET_TITLE_MAX_LENGTH, ['required' => true]);

			$this->addText('name', $widget->name, FORM_FIELD_TEXT, CONFIG_WIDGET_NAME_MAX_LENGTH,

				['required' => true, 'convert' => 'var']);

			$this->addCheckbox('display', $widget->display);

			$this->addText('contents', $widget->contents, FORM_FIELD_TEXTAREA, 0, ['multiline' => true, 'codestyle' => true]);
		}
	}
}
