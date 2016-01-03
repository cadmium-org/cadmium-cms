<?php

namespace System\Modules\Entitizer\Form {

	use System\Modules\Entitizer, System\Utils\Form, System\Utils\Lister;

	class Menuitem extends Form {

		# Constructor

		public function __construct(Entitizer\Entity\Menuitem $menuitem) {

			parent::__construct(ENTITY_TYPE_MENUITEM);

			# Add fields

			$this->addText('parent_id', $menuitem->parent_id, FORM_FIELD_HIDDEN);

			$this->addText('text', $menuitem->text, FORM_FIELD_TEXT, CONFIG_MENUITEM_TEXT_MAX_LENGTH, ['required' => true]);

			$this->addText('slug', $menuitem->slug, FORM_FIELD_TEXT, CONFIG_MENUITEM_SLUG_MAX_LENGTH);

			$this->addSelect('target', $menuitem->target, Lister\Target::list());

			$this->addText('position', $menuitem->position, FORM_FIELD_TEXT, CONFIG_MENUITEM_POSITION_MAX_LENGTH);
		}
	}
}
