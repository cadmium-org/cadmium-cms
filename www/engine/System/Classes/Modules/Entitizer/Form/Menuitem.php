<?php

namespace Modules\Entitizer\Form {

	use Modules\Entitizer, Utils\Form, Utils\Range;

	class Menuitem extends Form {

		# Constructor

		public function __construct(Entitizer\Entity\Menuitem $menuitem) {

			parent::__construct('menuitem');

			# Add fields

			$this->addText('text', $menuitem->text, FORM_FIELD_TEXT, CONFIG_MENUITEM_TEXT_MAX_LENGTH, ['required' => true]);

			$this->addText('slug', $menuitem->slug, FORM_FIELD_TEXT, CONFIG_MENUITEM_SLUG_MAX_LENGTH, ['required' => true]);

			$this->addSelect('target', $menuitem->target, Range\Target::array());

			$this->addCheckbox('active', $menuitem->active);

			$this->addText('position', $menuitem->position, FORM_FIELD_TEXT, CONFIG_MENUITEM_POSITION_MAX_LENGTH);
		}
	}
}
