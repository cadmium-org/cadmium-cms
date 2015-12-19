<?php

namespace System\Modules\Entitizer\Handler {

	use System\Modules\Entitizer, Template;

	class Menuitem extends Entitizer\Utils\Handler {

		use Entitizer\Common\Menuitem;

		# Handler configuration

		protected static $controller = 'System\Modules\Entitizer\Controller\Menuitem';

		protected static $link = '/admin/content/menuitems';

		protected static $naming = 'text', $naming_new = '';

		protected static $form_class = 'System\Modules\Entitizer\Form\Menuitem';

		protected static $message_success_save = 'MENUITEM_SUCCESS_SAVE';

		protected static $message_error_remove = 'MENUITEM_ERROR_REMOVE';

		protected static $view = 'Blocks\Entitizer\Menuitems\Main';

		# Add additional data for specific entity

		protected function processEntity(Template\Asset\Block $contents) {

			if ((0 === $this->parent->id) || ('' === $this->parent->link)) {

				$contents->block('parent')->block('browse')->disable();

			} else $contents->block('parent')->block('browse')->link = (INSTALL_PATH . $this->parent->link);
		}
	}
}
