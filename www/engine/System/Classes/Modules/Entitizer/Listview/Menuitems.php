<?php

namespace System\Modules\Entitizer\Listview {

	use System\Modules\Entitizer, Template;

	abstract class Menuitems {

		use Entitizer\Common\Menuitem;
		use Entitizer\Utils\Lister;
		use Entitizer\Utils\Listview;

		private static $link = '/admin/content/menuitems';

		private static $naming = 'text';

		private static $select = array('position', 'link', 'text'), $order_by = 'position ASC';

		private static $display = CONFIG_ADMIN_MENUITEMS_DISPLAY;

		private static $view_main = 'Blocks\Entitizer\Menuitems\Listview\Main';

		private static $view_item = 'Blocks\Entitizer\Menuitems\Listview\Item';

		private static $view_ajax_main = 'Blocks\Entitizer\Menuitems\Ajax\Main';

		private static $view_ajax_item = 'Blocks\Entitizer\Menuitems\Ajax\Item';

		# Add additional data for specific entity

		private static function processEntity(Template\Utils\Block $contents) {

			if (0 === self::$parent->id) $contents->block('parent')->block('browse')->disable();

			else $contents->block('parent')->block('browse')->link = self::$parent->link;
		}

		# Add item additional data

		private static function processItem(Template\Utils\Block $view, array $data) {

			$view->icon = ((0 === $data['children']) ? 'file text outline' : 'folder');

			$view->position = $data['position'];

			$view->block('browse')->class = (('' !== $data['link']) ? 'primary' : 'disabled');

			$view->block('browse')->link = $data['link'];
		}
	}
}
