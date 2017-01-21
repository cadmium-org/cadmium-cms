<?php

namespace Modules\Entitizer\Handler\Edit {

	use Modules\Entitizer, Template;

	class Menuitem extends Entitizer\Utils\Handler {

		use Entitizer\Common\Menuitem;

		protected $_title = 'TITLE_CONTENT_MENUITEMS_EDIT';

		# Handler configuration

		protected static $controller = 'Modules\Entitizer\Controller\Menuitem';

		protected static $link = '/admin/content/menuitems';

		protected static $naming = 'text', $naming_new = '';

		protected static $form_class = 'Modules\Entitizer\Form\Menuitem';

		protected static $message_success_save = 'MENUITEM_SUCCESS_SAVE';

		protected static $message_error_move = 'MENUITEM_ERROR_MOVE';

		protected static $message_error_remove = 'MENUITEM_ERROR_REMOVE';

		protected static $view = 'Blocks/Entitizer/Menuitems/Main';

		# Add parent additional data

		protected function processEntityParent(Template\Block $parent) {

			if (0 !== $this->parent->id) $parent->getBlock('browse')->link = $this->parent->link;

			else { $parent->getBlock('browse')->disable(); $parent->getBlock('browse_disabled')->enable(); }
		}

		# Add additional data for specific entity

		protected function processEntity(Template\Block $contents) {}
	}
}
