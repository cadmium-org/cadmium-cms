<?php

namespace System\Modules\Filemanager\Form {

	use System\Utils\Form, Language;

	class Create extends Form {

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

			parent::__construct('create');

			# Add fields

			$this->select('type', FILEMANAGER_TYPE_DIR, $this->getOptions(), null, ['disabled' => true]);

			$this->input('name', '', FORM_INPUT_TEXT, CONFIG_FILEMANAGER_NAME_MAX_LENGTH,

				['placeholder' => Language::get('FILEMANAGER_FIELD_NAME'), 'required' => true]);
		}
	}
}
