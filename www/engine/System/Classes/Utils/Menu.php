<?php

namespace Utils {

	use Modules\Entitizer, Template;

	class Menu {

		private $menu = [0 => ['children' => []]];

		# Parse item

		private function parseItem(int $id) {

			if ([] !== $this->menu[$id]['children']) {

				$item = View::get('Blocks/Utils/Menu/Container');

				$item->text = $this->menu[$id]['dataset']->text;

				$item->children = ($children = Template::createBlock());

				foreach ($this->menu[$id]['children'] as $child) $children->addItem($this->parseItem($child));

			} else {

				$item = View::get('Blocks/Utils/Menu/Item');

				$item->target = (($this->menu[$id]['dataset']->target === TARGET_BLANK) ? '_blank' : '_self');

				$item->link = $this->menu[$id]['dataset']->link;

				$item->text = $this->menu[$id]['dataset']->text;
			}

			# ------------------------

			return $item;
		}

		# Constructor

		public function __construct() {

			$menu = Entitizer::treeview(TABLE_MENU)->subtree(0, ['active' => true]);

			if (false !== $menu) $this->menu = $menu;
		}

		# Get block

		public function block() {

			$menu = Template::createBlock();

			foreach ($this->menu[0]['children'] as $id) $menu->addItem($this->parseItem($id));

			# ------------------------

			return $menu;
		}
	}
}
