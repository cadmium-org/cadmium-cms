<?php

namespace System\Modules\Entitizer\Listview {

	use System\Modules\Entitizer, System\Utils\Lister, Template;

	abstract class Users {

		use Entitizer\Common\User;
		use Entitizer\Utils\Lister;
		use Entitizer\Utils\Listview;

		private static $link = '/admin/system/users';

		private static $naming = 'name';

		private static $select = array('rank', 'name'), $order_by = array('rank DESC', 'name ASC');

		private static $display = CONFIG_ADMIN_USERS_DISPLAY;

		private static $view_main = 'Blocks\Entitizer\Users\Listview\Main';

		private static $view_item = 'Blocks\Entitizer\Users\Listview\Item';

		private static $view_ajax_main = '';

		private static $view_ajax_item = '';

		# Add additional data for specific entity

		private static function processEntity(Template\Utils\Block $contents) {}

		# Add item additional data

		private static function processItem(Template\Utils\Block $view, array $data) {

			$view->rank = Lister\Rank::get($data['rank']);
		}
	}
}
