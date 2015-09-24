<?php

namespace System\Modules\Entitizer\Listview {

	use System\Modules\Entitizer, System\Utils\Lister, Template;

	class Users extends Entitizer\Utils\Listview {

		use Entitizer\Common\User;

		# Listview configuration

		protected static $link = '/admin/system/users';

		protected static $naming = 'name';

		protected static $display = CONFIG_ADMIN_USERS_DISPLAY;

		protected static $view_main = 'Blocks\Entitizer\Users\Listview\Main';

		protected static $view_item = 'Blocks\Entitizer\Users\Listview\Item';

		protected static $view_ajax_main = '';

		protected static $view_ajax_item = '';

		# Add additional data for specific entity

		protected function processEntity() {}

		# Add item additional data

		protected function processItem(Template\Utils\Block $view, array $data) {

			$view->rank = Lister\Rank::get($data['rank']);
		}
	}
}
