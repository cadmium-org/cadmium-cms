<?php

namespace Modules\Filemanager\Form {

	use Utils\Form, Language;

	class Create extends Form {

		protected $name = 'create';

		# Get options

		private function getOptions() {

			$options = [];

			$options[FILEMANAGER_TYPE_DIR]      = Language::get('FILEMANAGER_DIR');
			$options[FILEMANAGER_TYPE_FILE]     = Language::get('FILEMANAGER_FILE');

			# ------------------------

			return $options;
		}

		# Constructor

		public function __construct() {

			$this->addSelect('type', FILEMANAGER_TYPE_DIR, $this->getOptions(), null, ['disabled' => true]);

			$this->addText('name', '', FORM_FIELD_TEXT, CONFIG_FILEMANAGER_NAME_MAX_LENGTH,

				['placeholder' => Language::get('FILEMANAGER_FIELD_NAME'), 'required' => true]);
		}
	}
}
