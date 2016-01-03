<?php

namespace System\Modules\Entitizer\Handler {

	use System\Modules\Entitizer, Template;

	class Page extends Entitizer\Utils\Handler {

		use Entitizer\Common\Page;

		# Handler configuration

		protected static $controller = 'System\Modules\Entitizer\Controller\Page';

		protected static $link = '/admin/content/pages';

		protected static $naming = 'title', $naming_new = '';

		protected static $form_class = 'System\Modules\Entitizer\Form\Page';

		protected static $message_success_save = 'PAGE_SUCCESS_SAVE';

		protected static $message_error_remove = 'PAGE_ERROR_REMOVE';

		protected static $view = 'Blocks\Entitizer\Pages\Main';

		# Add additional data for specific entity

		protected function processEntity(Template\Asset\Block $contents) {

			if ((0 === $this->parent->id) || !$this->parent->visibility) {

				$contents->block('parent')->block('browse')->disable();

			} else $contents->block('parent')->block('browse')->link = $this->parent->link;
		}
	}
}
