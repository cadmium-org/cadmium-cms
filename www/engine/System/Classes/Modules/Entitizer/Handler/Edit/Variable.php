<?php

namespace Modules\Entitizer\Handler\Edit {

	use Modules\Entitizer;

	class Variable extends Entitizer\Utils\Handler {

		use Entitizer\Common\Variable;

		protected $title = 'TITLE_CONTENT_VARIABLES_EDIT';

		# Handler configuration

		protected static $controller = 'Modules\Entitizer\Controller\Variable';

		protected static $link = '/admin/content/variables';

		protected static $naming = 'title', $naming_new = 'VARIABLES_ITEM_NEW';

		protected static $form_class = 'Modules\Entitizer\Form\Variable';

		protected static $message_success_save = 'VARIABLE_SUCCESS_SAVE';

		protected static $message_error_remove = 'VARIABLE_ERROR_REMOVE';

		protected static $view = 'Blocks/Entitizer/Variables/Main';

		# Add additional data for specific entity

		protected function processEntity() {}
	}
}
