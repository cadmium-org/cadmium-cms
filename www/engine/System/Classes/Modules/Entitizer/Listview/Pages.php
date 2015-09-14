<?php

namespace System\Modules\Entitizer\Listview {

	use System\Modules\Entitizer, System\Utils\Lister, Template;

	abstract class Pages {

		use Entitizer\Common\Page;
		use Entitizer\Utils\Lister;
		use Entitizer\Utils\Listview;

		private static $link = '/admin/content/pages';

		private static $naming = 'title';

		private static $select = array('visibility', 'access', 'name', 'title'), $order_by = 'title ASC';

		private static $display = CONFIG_ADMIN_PAGES_DISPLAY;

		private static $view_main = 'Blocks\Entitizer\Pages\Listview\Main';

		private static $view_item = 'Blocks\Entitizer\Pages\Listview\Item';

		private static $view_ajax_main = 'Blocks\Entitizer\Pages\Ajax\Main';

		private static $view_ajax_item = 'Blocks\Entitizer\Pages\Ajax\Item';

		# Add additional data for specific entity

		private static function processEntity(Template\Utils\Block $contents) {

			if (0 === self::$parent->id) $contents->block('parent')->block('browse')->disable();

			else $contents->block('parent')->block('browse')->link = self::$parent->link;
		}

		# Add item additional data

		private static function processItem(Template\Utils\Block $view, array $data) {

			$view->icon = ((0 === $data['children']) ? 'file text outline' : 'folder');

			$view->access = Lister\Access::get($data['access']);

			$view->block('browse')->class = (('' !== $data['visibility']) ? 'primary' : 'disabled');

			$view->block('browse')->link = (self::$parent->link . '/' . $data['name']);
		}
	}
}
