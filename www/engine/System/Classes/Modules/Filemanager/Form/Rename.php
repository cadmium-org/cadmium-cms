<?php

namespace System\Modules\Filemanager\Form {

	use System\Modules\Filemanager, System\Utils\Form, Language;

	class Rename extends Form {

		# Constructor

		public function __construct(Filemanager\Utils\Entity $entity) {

			parent::__construct('rename');

			# Add fields

			$this->input('name', $entity->name(), FORM_INPUT_TEXT, CONFIG_FILEMANAGER_NAME_MAX_LENGTH,

				['placeholder' => Language::get('FILEMANAGER_FIELD_NAME'), 'required' => true]);
		}
	}
}
