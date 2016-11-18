<?php

namespace Modules\Entitizer\Form {

	use Modules\Entitizer, Utils\Form;

	class Widget extends Form {

		protected $name = 'widget';

		# Constructor

		public function __construct(Entitizer\Entity\Widget $widget) {

			$this->addText('title', $widget->title, FORM_FIELD_TEXT, CONFIG_WIDGET_TITLE_MAX_LENGTH, ['required' => true]);

			$this->addText('name', $widget->name, FORM_FIELD_TEXT, CONFIG_WIDGET_NAME_MAX_LENGTH,

				['required' => true, 'convert' => 'var']);

			$this->addCheckbox('active', $widget->active);

			$this->addText('contents', $widget->contents, FORM_FIELD_TEXTAREA, 0, ['multiline' => true, 'codestyle' => true]);
		}
	}
}
