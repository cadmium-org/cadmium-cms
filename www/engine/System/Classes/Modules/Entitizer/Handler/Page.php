<?php

namespace System\Modules\Entitizer\Handler {

	use System\Modules\Entitizer, Template;

	abstract class Page {

		use Entitizer\Common\Page, Entitizer\Utils\Handler;

		private static $link = '/admin/content/pages';

		private static $naming = 'title', $naming_new = '';

		private static $form_class = 'System\Modules\Entitizer\Form\Page';

		private static $message_success_create = 'PAGE_SUCCESS_CREATE';

		private static $message_success_save = 'PAGE_SUCCESS_SAVE';

		private static $view = 'Blocks\Entitizer\Pages\Main';

		# Add additional data for specific entity

		private static function processEntity(Template\Utils\Block $contents) {

			if (0 === self::$parent->id) $contents->block('parent')->block('browse')->disable();

			else $contents->block('parent')->block('browse')->link = self::$parent->link;
		}
	}
}
