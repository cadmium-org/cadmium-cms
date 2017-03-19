<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Handler\Edit {

	use Modules\Entitizer, Template;

	class Menuitem extends Entitizer\Utils\Handler {

		use Entitizer\Common\Menuitem;

		protected $_title = 'TITLE_CONTENT_MENUITEMS_EDIT';

		# Handler configuration

		protected static $naming = 'text', $naming_new = '';

		protected static $view = 'Blocks/Entitizer/Menuitems/Main';

		protected static $form_class = 'Modules\Entitizer\Form\Menuitem';

		protected static $controller_class = 'Modules\Entitizer\Controller\Menuitem';

		protected static $message_success_save = 'MENUITEM_SUCCESS_SAVE';

		protected static $message_error_move = 'MENUITEM_ERROR_MOVE';

		protected static $message_error_remove = 'MENUITEM_ERROR_REMOVE';

		protected static $link = '/admin/content/menuitems';

		/**
		 * Add parent's additional data
		 */

		protected function processEntityParent(Template\Block $parent) {

			if (0 !== $this->parent->id) $parent->getBlock('browse')->link = $this->parent->link;

			else { $parent->getBlock('browse')->disable(); $parent->getBlock('browse_disabled')->enable(); }
		}

		/**
		 * Add additional data for a specific entity
		 */

		protected function processEntity(Template\Block $contents) {}
	}
}
