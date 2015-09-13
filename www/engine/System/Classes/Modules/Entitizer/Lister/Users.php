<?php

namespace System\Modules\Entitizer\Listview {

	use System\Modules\Entitizer, System\Utils\Lister;

	abstract class Users {

		use Entitizer\Common\User, Entitizer\Utils\Lister;

		protected static $select = array('rank', 'name'), $order_by = array('rank DESC', 'name ASC');

		protected static $display = CONFIG_ADMIN_USERS_DISPLAY;
	}
}
