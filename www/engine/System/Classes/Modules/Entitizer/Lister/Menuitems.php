<?php

namespace Modules\Entitizer\Lister {

	use Modules\Entitizer, Template;

	class Menuitems extends Entitizer\Utils\Lister {

		use Entitizer\Common\Menuitem;

		protected $_title = 'TITLE_CONTENT_MENUITEMS';

		# Lister configuration

		protected static $link = '/admin/content/menuitems';

		protected static $naming = 'text';

		protected static $view_main = 'Blocks/Entitizer/Menuitems/Lister/Main';

		protected static $view_item = 'Blocks/Entitizer/Menuitems/Lister/Item';

		protected static $view_ajax_main = 'Blocks/Entitizer/Menuitems/Ajax/Main';

		protected static $view_ajax_item = 'Blocks/Entitizer/Menuitems/Ajax/Item';

		# Add parent additional data

		protected function processEntityParent(Template\Block $parent) {

			if (0 !== $this->parent->id) $parent->getBlock('browse')->link = $this->parent->link;

			else { $parent->getBlock('browse')->disable(); $parent->getBlock('browse_disabled')->enable(); }
		}

		# Add item additional data

		protected function processItem(Template\Block $view, Entitizer\Dataset\Menuitem $menuitem, int $children = 0) {

			$view->class = (!$menuitem->active ? 'inactive' : '');

			$view->icon = ((0 === $children) ? 'bars' : 'folder');

			$view->position = $menuitem->position;

			# Set browse button

			$view->getBlock('browse')->class = 'primary';

			$view->getBlock('browse')->link = $menuitem->link;
		}
	}
}
