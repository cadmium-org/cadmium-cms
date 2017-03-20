<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Handler\Edit {

	use Modules\Entitizer;

	class Variable extends Entitizer\Utils\Handler {

		use Entitizer\Common\Variable;

		protected $_title = 'TITLE_CONTENT_VARIABLES_EDIT';

		# Handler configuration

		protected static $naming = 'title', $naming_new = 'VARIABLES_ITEM_NEW';

		protected static $view = 'Blocks/Entitizer/Variables/Main';

		protected static $form_class = 'Modules\Entitizer\Form\Variable';

		protected static $controller_class = 'Modules\Entitizer\Controller\Variable';

		protected static $message_success_save = 'VARIABLE_SUCCESS_SAVE';

		protected static $message_error_remove = 'VARIABLE_ERROR_REMOVE';

		protected static $link = '/admin/content/variables';

		/**
		 * Add additional data for a specific entity
		 */

		protected function processEntity() {}
	}
}
