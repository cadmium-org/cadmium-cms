<?php

namespace System\Modules\Entitizer\Listview {

	use System\Modules\Entitizer, Template;

	class Menuitems extends Entitizer\Utils\Listview {

		use Entitizer\Common\Menuitem;

		# Listview configuration

		protected static $link = '/admin/content/menuitems';

		protected static $naming = 'text';

		protected static $display = CONFIG_ADMIN_MENUITEMS_DISPLAY;

		protected static $view_main = 'Blocks\Entitizer\Menuitems\Listview\Main';

		protected static $view_item = 'Blocks\Entitizer\Menuitems\Listview\Item';

		protected static $view_ajax_main = 'Blocks\Entitizer\Menuitems\Ajax\Main';

		protected static $view_ajax_item = 'Blocks\Entitizer\Menuitems\Ajax\Item';

		# Add additional data for specific entity

		protected function processEntity(Template\Utils\Block $contents) {

			if (0 === $this->parent->id) $contents->block('parent')->block('browse')->disable();

			else $contents->block('parent')->block('browse')->link = $this->parent->link;
		}

		# Add item additional data

		protected function processItem(Template\Utils\Block $view, array $data) {

			$view->icon = ((0 === $data['children']) ? 'file text outline' : 'folder');

			$view->position = $data['position'];

			# Set browse button

			$view->block('browse')->class = (('' !== $data['link']) ? 'primary' : 'disabled');

			$view->block('browse')->link = $data['link'];
		}
	}
}
