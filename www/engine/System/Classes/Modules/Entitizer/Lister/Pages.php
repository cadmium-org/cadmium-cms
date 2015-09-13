<?php

namespace System\Modules\Entitizer\Listview {

	use System\Modules\Entitizer, System\Utils\Lister;

	abstract class Pages {

		use Entitizer\Common\Page, Entitizer\Utils\Lister;

		protected static $select = array('visibility', 'access', 'name', 'title'), $order_by = 'title ASC';

		protected static $display = CONFIG_ADMIN_PAGES_DISPLAY;
	}
}
