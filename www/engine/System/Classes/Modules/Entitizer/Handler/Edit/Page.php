<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Handler\Edit {

	use Modules\Entitizer, Template;

	class Page extends Entitizer\Utils\Handler {

		use Entitizer\Common\Page;

		protected $_title = 'TITLE_CONTENT_PAGES_EDIT';

		# Handler configuration

		protected static $naming = 'title', $naming_new = '';

		protected static $view = 'Blocks/Entitizer/Pages/Main';

		protected static $form_class = 'Modules\Entitizer\Form\Page';

		protected static $controller_class = 'Modules\Entitizer\Controller\Page';

		protected static $message_success_save = 'PAGE_SUCCESS_SAVE';

		protected static $message_error_move = 'PAGE_ERROR_MOVE';

		protected static $message_error_remove = 'PAGE_ERROR_REMOVE';

		protected static $link = '/admin/content/pages';

		/**
		 * Add parent's additional data
		 */

		protected function processEntityParent(Template\Block $parent) {

			if ((0 !== $this->parent->id) && $this->parent->active) $parent->getBlock('browse')->link = $this->parent->link;

			else { $parent->getBlock('browse')->disable(); $parent->getBlock('browse_disabled')->enable(); }
		}

		/**
		 * Add additional data for a specific entity
		 */

		protected function processEntity(Template\Block $contents) {

			if (!$this->create && $this->parent->locked) $contents->getBlock('locked')->enable();
		}
	}
}
