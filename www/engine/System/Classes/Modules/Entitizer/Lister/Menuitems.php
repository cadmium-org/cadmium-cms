<?php

namespace Modules\Entitizer\Lister {

	use Modules\Entitizer, Template;

	class Menuitems extends Entitizer\Utils\Lister {

		use Entitizer\Common\Menuitem;

		# Lister configuration

		protected static $link = '/admin/content/menuitems';

		protected static $naming = 'text';

		protected static $display = CONFIG_ADMIN_MENUITEMS_DISPLAY;

		protected static $view_main = 'Blocks\Entitizer\Menuitems\Lister\Main';

		protected static $view_item = 'Blocks\Entitizer\Menuitems\Lister\Item';

		protected static $view_ajax_main = 'Blocks\Entitizer\Menuitems\Ajax\Main';

		protected static $view_ajax_item = 'Blocks\Entitizer\Menuitems\Ajax\Item';

		# Add parent additional data

		protected function processEntityParent(Template\Asset\Block $parent) {

			if (0 === $this->parent->id) {

				$parent->block('browse')->disable(); $parent->block('browse_disabled')->enable();

			} else $parent->block('browse')->link = $this->parent->link;
		}

		# Add item additional data

		protected function processItem(Template\Asset\Block $view, Entitizer\Dataset\Menuitem $menuitem, int $children = 0) {

			$view->class = (!$menuitem->active ? 'inactive' : '');

			$view->icon = ((0 === $children) ? 'bars' : 'folder');

			$view->position = $menuitem->position;

			# Set browse button

			$view->block('browse')->class = 'primary';

			$view->block('browse')->link = $menuitem->link;
		}
	}
}
