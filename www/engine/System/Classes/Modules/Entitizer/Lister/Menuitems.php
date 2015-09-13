<?php

namespace System\Modules\Entitizer\Listview {

	use System\Modules\Entitizer;

	abstract class Menuitems {

		use Entitizer\Common\Menuitem, Entitizer\Utils\Lister;

		protected static $select = array('position', 'link', 'text'), $order_by = 'position ASC';

		protected static $display = CONFIG_ADMIN_MENUITEMS_DISPLAY;
	}
}
