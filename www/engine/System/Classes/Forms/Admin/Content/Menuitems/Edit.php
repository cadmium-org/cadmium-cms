<?php

namespace System\Forms\Admin\Content\Menuitems {

	use System\Utils\Entitizer, System\Utils\Lister, Form;

	class Edit extends Form {

        # Constructor

        public function __construct(Entitizer\Type\Menuitem\Manager $menuitem) {

            parent::__construct('menuitem');

            # Add fields

			$this->input('parent_id', $menuitem->parent_id, FORM_INPUT_HIDDEN);

			$this->input('text', $menuitem->text, FORM_INPUT_TEXT, CONFIG_MENUITEM_TEXT_MAX_LENGTH, '', FORM_FIELD_REQUIRED);

			$this->input('link', $menuitem->link, FORM_INPUT_TEXT, CONFIG_MENUITEM_LINK_MAX_LENGTH, '');

			$this->select('target', $menuitem->target, Lister\Target::range());

			$this->input('position', $menuitem->position, FORM_INPUT_TEXT, CONFIG_MENUITEM_POSITION_MAX_LENGTH);
        }
    }
}
