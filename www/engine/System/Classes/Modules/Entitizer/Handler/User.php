<?php

namespace System\Modules\Entitizer\Handler {

	use System\Modules\Entitizer, Template, Date;

	abstract class User {

		use Entitizer\Common\User, Entitizer\Utils\Handler;

		private static $link = '/admin/system/users';

		private static $naming = 'name', $naming_new = 'USERS_ITEM_NEW';

		private static $form_class = 'System\Modules\Entitizer\Form\User';

		private static $message_success_create = 'USER_SUCCESS_CREATE';

		private static $message_success_save = 'USER_SUCCESS_SAVE';

		private static $view = 'Blocks\Entitizer\Users\Main';

		# Add additional data for specific entity

		private static function processEntity(Template\Utils\Block $contents) {

			if (self::$create) return $contents->block('info')->disable();

			$contents->block('info')->time_registered = Date::get(DATE_FORMAT_DATETIME, self::$entity->time_registered);

			$contents->block('info')->time_logged = Date::get(DATE_FORMAT_DATETIME, self::$entity->time_logged);
		}
	}
}
