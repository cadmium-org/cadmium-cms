<?php

namespace Modules\Entitizer\Handler\Edit {

	use Modules\Entitizer, Template, Date;

	class User extends Entitizer\Utils\Handler {

		use Entitizer\Common\User;

		protected $title = 'TITLE_SYSTEM_USERS_EDIT';

		# Handler configuration

		protected static $controller = 'Modules\Entitizer\Controller\User';

		protected static $link = '/admin/system/users';

		protected static $naming = 'name', $naming_new = 'USERS_ITEM_NEW';

		protected static $form_class = 'Modules\Entitizer\Form\User';

		protected static $message_success_save = 'USER_SUCCESS_SAVE';

		protected static $message_error_remove = 'USER_ERROR_REMOVE';

		protected static $view = 'Blocks/Entitizer/Users/Main';

		# Add additional data for specific entity

		protected function processEntity(Template\Block $contents) {

			if ($this->create) $contents->getBlock('info')->disable(); else {

				$contents->getBlock('info')->time_registered = Date::get(DATE_FORMAT_DATETIME, $this->entity->time_registered);

				$contents->getBlock('info')->time_logged = Date::get(DATE_FORMAT_DATETIME, $this->entity->time_logged);
			}
		}
	}
}
