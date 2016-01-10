<?php

namespace Modules\Entitizer\Listview {

	use Modules\Entitizer, Utils\Lister, Template;

	class Pages extends Entitizer\Utils\Listview {

		use Entitizer\Common\Page;

		# Listview configuration

		protected static $lister = 'Modules\Entitizer\Lister\Pages';

		protected static $link = '/admin/content/pages';

		protected static $naming = 'title';

		protected static $display = CONFIG_ADMIN_PAGES_DISPLAY;

		protected static $view_main = 'Blocks\Entitizer\Pages\Listview\Main';

		protected static $view_item = 'Blocks\Entitizer\Pages\Listview\Item';

		protected static $view_ajax_main = 'Blocks\Entitizer\Pages\Ajax\Main';

		protected static $view_ajax_item = 'Blocks\Entitizer\Pages\Ajax\Item';

		# Add additional data for specific entity

		protected function processEntity(Template\Asset\Block $contents) {

			if ((0 === $this->parent->id) || !$this->parent->visibility) {

				$contents->block('parent')->block('browse')->disable();

			} else $contents->block('parent')->block('browse')->link = $this->parent->link;
		}

		# Add item additional data

		protected function processItem(Template\Asset\Block $view, Entitizer\Entity\Page $page, int $children = 0) {

			$view->slug = $page->slug;

			$view->icon = ((0 === $children) ? 'file text outline' : 'folder');

			$view->access = Lister\Access::get($page->access);

			# Set browse button

			$view->block('browse')->class = ($page->visibility ? 'primary' : 'disabled');

			$view->block('browse')->link = $page->link;
		}
	}
}
