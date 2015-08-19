<?php

namespace System\Forms\Admin\Content\Menuitems {

	use Form;

	class Create extends Form {

        # Constructor

        public function __construct() {

            parent::__construct('menuitem');

            # Add fields

            $this->input('text', '', FORM_INPUT_TEXT, CONFIG_MENUITEM_TEXT_MAX_LENGTH, '', FORM_FIELD_REQUIRED);

			$this->input('link', '', FORM_INPUT_TEXT, CONFIG_MENUITEM_LINK_MAX_LENGTH);
        }
    }
}
