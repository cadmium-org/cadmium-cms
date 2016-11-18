<?php

namespace Modules\Filemanager\Form {

	use Modules\Filemanager, Utils\Form, Language;

	class Rename extends Form {

		protected $name = 'rename';

		# Constructor

		public function __construct(Filemanager\Utils\Entity $entity) {

			$this->addText('name', $entity->name(), FORM_FIELD_TEXT, CONFIG_FILEMANAGER_NAME_MAX_LENGTH,

				['placeholder' => Language::get('FILEMANAGER_FIELD_NAME'), 'required' => true]);
		}
	}
}
