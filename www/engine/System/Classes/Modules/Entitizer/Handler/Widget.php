<?php

namespace Modules\Entitizer\Handler {

	use Modules\Entitizer;

	class Widget extends Entitizer\Utils\Handler {

		use Entitizer\Common\Widget;

		# Handler configuration

		protected static $controller = 'Modules\Entitizer\Controller\Widget';

		protected static $link = '/admin/content/widgets';

		protected static $naming = 'title', $naming_new = 'WIDGETS_ITEM_NEW';

		protected static $form_class = 'Modules\Entitizer\Form\Widget';

		protected static $message_success_save = 'WIDGET_SUCCESS_SAVE';

		protected static $message_error_remove = 'WIDGET_ERROR_REMOVE';

		protected static $view = 'Blocks\Entitizer\Widgets\Main';

		# Add additional data for specific entity

		protected function processEntity() {}
	}
}
