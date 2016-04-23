<?php

namespace Modules\Entitizer\Lister {

	use Modules\Entitizer, Utils\Range, Template;

	class Pages extends Entitizer\Utils\Lister {

		use Entitizer\Common\Page;

		# Lister configuration

		protected static $link = '/admin/content/pages';

		protected static $naming = 'title';

		protected static $display = CONFIG_ADMIN_PAGES_DISPLAY;

		protected static $view_main = 'Blocks\Entitizer\Pages\Lister\Main';

		protected static $view_item = 'Blocks\Entitizer\Pages\Lister\Item';

		protected static $view_ajax_main = 'Blocks\Entitizer\Pages\Ajax\Main';

		protected static $view_ajax_item = 'Blocks\Entitizer\Pages\Ajax\Item';

		# Add parent additional data

		protected function processEntityParent(Template\Asset\Block $parent) {

			if ((0 === $this->parent->id) || !$this->parent->active) {

				$parent->block('browse')->disable(); $parent->block('browse_disabled')->enable();

			} else $parent->block('browse')->link = $this->parent->link;
		}

		# Add item additional data

		protected function processItem(Template\Asset\Block $view, Entitizer\Dataset\Page $page, int $children = 0) {

			$view->class = ($page->locked ? 'inactive warning' : (!$page->active ? 'inactive' : ''));

			$view->slug = $page->slug;

			$view->icon = ((0 === $children) ? 'file text outline' : 'folder');

			$view->access = Range\Access::get($page->access);

			# Set browse button

			$view->block('browse')->class = ($page->active ? 'primary' : 'disabled');

			$view->block('browse')->link = $page->link;
		}
	}
}
