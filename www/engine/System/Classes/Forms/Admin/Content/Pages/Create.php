<?php

namespace System\Forms\Admin\Content\Pages {

	use Form;

	class Create extends Form {

        # Constructor

        public function __construct() {

            parent::__construct('page');

            # Add fields

			$this->input('title', '', FORM_INPUT_TEXT, CONFIG_PAGE_TITLE_MAX_LENGTH, '', FORM_FIELD_REQUIRED);

			$this->input('name', '', FORM_INPUT_TEXT, CONFIG_PAGE_NAME_MAX_LENGTH, '', FORM_FIELD_REQUIRED | FORM_FIELD_TRANSLIT);
        }
    }
}
