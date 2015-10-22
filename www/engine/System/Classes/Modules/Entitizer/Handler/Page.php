<?php

namespace System\Modules\Entitizer\Handler {

	use System\Modules\Entitizer, Template;

	class Page extends Entitizer\Utils\Handler {

		use Entitizer\Common\Page;

		# Handler configuration

		protected static $link = '/admin/content/pages';

		protected static $naming = 'title', $naming_new = '';

		protected static $form_class = 'System\Modules\Entitizer\Form\Page';

		protected static $message_success_create = 'PAGE_SUCCESS_CREATE';

		protected static $message_success_save = 'PAGE_SUCCESS_SAVE';

		protected static $view = 'Blocks\Entitizer\Pages\Main';

		# Add additional data for specific entity

		protected function processEntity(Template\Utils\Block $contents) {

			if ((0 === $this->parent->id) || !$this->parent->visibility) {

				$contents->block('parent')->block('browse')->disable();

			} else $contents->block('parent')->block('browse')->link = (INSTALL_PATH . $this->parent->link);
		}
	}
}
