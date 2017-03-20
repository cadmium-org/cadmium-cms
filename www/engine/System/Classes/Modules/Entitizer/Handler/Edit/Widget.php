<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Handler\Edit {

	use Modules\Entitizer;

	class Widget extends Entitizer\Utils\Handler {

		use Entitizer\Common\Widget;

		protected $_title = 'TITLE_CONTENT_WIDGETS_EDIT';

		# Handler configuration

		protected static $naming = 'title', $naming_new = 'WIDGETS_ITEM_NEW';

		protected static $view = 'Blocks/Entitizer/Widgets/Main';

		protected static $form_class = 'Modules\Entitizer\Form\Widget';

		protected static $controller_class = 'Modules\Entitizer\Controller\Widget';

		protected static $message_success_save = 'WIDGET_SUCCESS_SAVE';

		protected static $message_error_remove = 'WIDGET_ERROR_REMOVE';

		protected static $link = '/admin/content/widgets';

		/**
		 * Add additional data for a specific entity
		 */

		protected function processEntity() {}
	}
}
