<?php

namespace System\Modules\Entitizer\Form {

	use System\Modules\Entitizer, System\Utils\Form, System\Utils\Lister;

	class Menuitem extends Form {

		# Constructor

		public function __construct(Entitizer\Entity\Menuitem $menuitem) {

			parent::__construct(ENTITY_TYPE_MENUITEM);

			# Add fields

			$this->input('parent_id', $menuitem->parent_id, FORM_INPUT_HIDDEN);

			$this->input('text', $menuitem->text, FORM_INPUT_TEXT, CONFIG_MENUITEM_TEXT_MAX_LENGTH, ['required' => true]);

			$this->input('link', $menuitem->link, FORM_INPUT_TEXT, CONFIG_MENUITEM_LINK_MAX_LENGTH);

			$this->select('target', $menuitem->target, Lister\Target::list());

			$this->input('position', $menuitem->position, FORM_INPUT_TEXT, CONFIG_MENUITEM_POSITION_MAX_LENGTH);
		}
	}
}
