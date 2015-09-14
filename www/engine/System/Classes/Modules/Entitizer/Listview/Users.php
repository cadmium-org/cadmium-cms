<?php

namespace System\Modules\Entitizer\Listview {

	use System\Modules\Entitizer, System\Utils\Lister, Template;
	
	/*
	 * @method Template\Utils\Settable|Ajax\Utils\Dataset handle()
	 */

	abstract class Users {

		use Entitizer\Common\User;
		use Entitizer\Utils\Lister;
		use Entitizer\Utils\Listview;

		protected static $link = '/admin/system/users';

		protected static $naming = 'name';

		protected static $select = array('rank', 'name'), $order_by = array('rank DESC', 'name ASC');

		protected static $display = CONFIG_ADMIN_USERS_DISPLAY;

		protected static $view_main = 'Blocks\Entitizer\Users\Listview\Main';

		protected static $view_item = 'Blocks\Entitizer\Users\Listview\Item';

		protected static $view_ajax_main = '';

		protected static $view_ajax_item = '';

		# Add additional data for specific entity

		protected static function processEntity(Template\Utils\Block $contents) {}

		# Add item additional data

		protected static function processItem(Template\Utils\Block $view, array $data) {

			$view->rank = Lister\Rank::get($data['rank']);
		}
	}
}
