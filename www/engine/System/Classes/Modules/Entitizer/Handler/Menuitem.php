<?php

namespace System\Modules\Entitizer\Handler {

	use System\Modules\Entitizer, Template;

	abstract class Menuitem {

		use Entitizer\Common\Menuitem, Entitizer\Utils\Handler;

		private static $link = '/admin/content/menuitems';

		private static $naming = 'text', $naming_new = '';

		private static $form_class = 'System\Modules\Entitizer\Form\Menuitem';

		private static $message_success_create = 'MENUITEM_SUCCESS_CREATE';

		private static $message_success_save = 'MENUITEM_SUCCESS_SAVE';

		private static $view = 'Blocks\Entitizer\Menuitems\Main';

		# Add additional data for specific entity

		private static function processEntity(Template\Utils\Block $contents) {

			if (0 === self::$parent->id) $contents->block('parent')->block('browse')->disable();

			else $contents->block('parent')->block('browse')->link = self::$parent->link;
		}
	}
}
