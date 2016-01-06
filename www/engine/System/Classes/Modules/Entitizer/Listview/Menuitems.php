<?php

namespace Modules\Entitizer\Listview {

	use Modules\Entitizer, Template;

	class Menuitems extends Entitizer\Utils\Listview {

		use Entitizer\Common\Menuitem;

		# Listview configuration

		protected static $lister = 'Modules\Entitizer\Lister\Menuitems';

		protected static $link = '/admin/content/menuitems';

		protected static $naming = 'text';

		protected static $display = CONFIG_ADMIN_MENUITEMS_DISPLAY;

		protected static $view_main = 'Blocks\Entitizer\Menuitems\Listview\Main';

		protected static $view_item = 'Blocks\Entitizer\Menuitems\Listview\Item';

		protected static $view_ajax_main = 'Blocks\Entitizer\Menuitems\Ajax\Main';

		protected static $view_ajax_item = 'Blocks\Entitizer\Menuitems\Ajax\Item';

		# Add additional data for specific entity

		protected function processEntity(Template\Asset\Block $contents) {

			if ((0 === $this->parent->id) || ('' === $this->parent->link)) {

				$contents->block('parent')->block('browse')->disable();

			} else $contents->block('parent')->block('browse')->link = $this->parent->link;
		}

		# Add item additional data

		protected function processItem(Template\Asset\Block $view, Entitizer\Entity\Menuitem $menuitem, int $children = 0) {

			$view->icon = ((0 === $children) ? 'bars' : 'folder');

			$view->position = $menuitem->position;

			# Set browse button

			$view->block('browse')->class = (('' !== $menuitem->link) ? 'primary' : 'disabled');

			$view->block('browse')->link = $menuitem->link;
		}
	}
}
