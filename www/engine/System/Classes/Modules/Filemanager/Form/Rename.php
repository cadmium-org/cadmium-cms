<?php

namespace System\Modules\Filemanager\Form {

	use System\Modules\Filemanager, System\Utils\Form, Language;

	class Rename extends Form {

		# Constructor

		public function __construct(Filemanager\Utils\Entity $entity) {

			parent::__construct('rename');

			# Add fields

			$this->addText('name', $entity->name(), FORM_FIELD_TEXT, CONFIG_FILEMANAGER_NAME_MAX_LENGTH,

				['placeholder' => Language::get('FILEMANAGER_FIELD_NAME'), 'required' => true]);
		}
	}
}
