<?php

namespace System\Modules\Entitizer\Handler {

	use System\Modules\Entitizer;

	class Variable extends Entitizer\Utils\Handler {

		use Entitizer\Common\Variable;

		# Handler configuration

		protected static $controller = 'System\Modules\Entitizer\Controller\Variable';

		protected static $link = '/admin/content/variables';

		protected static $naming = 'title', $naming_new = 'VARIABLES_ITEM_NEW';

		protected static $form_class = 'System\Modules\Entitizer\Form\Variable';

		protected static $message_success_save = 'VARIABLE_SUCCESS_SAVE';

		protected static $message_error_remove = 'VARIABLE_ERROR_REMOVE';

		protected static $view = 'Blocks\Entitizer\Variables\Main';

		# Add additional data for specific entity

		protected function processEntity() {}
	}
}
