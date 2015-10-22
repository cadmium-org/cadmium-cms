<?php

namespace System\Utils {

	use System\Utils\Lister, DB, Template;

	class Menu {

		private $items = [], $menu = [];

		# Parse item

		private function parseItem($id) {

			if (isset($this->items[$id]['children'])) {

				$item = View::get('Blocks\Utils\Menu\Container');

				$item->text = $this->items[$id]['text'];

				$item->children = ($children = Template::group());

				foreach ($this->items[$id]['children'] as $child) $children->add($this->parseItem($child));

			} else {

				$item = View::get('Blocks\Utils\Menu\Item');

				$item->target = (($this->items[$id]['target'] === TARGET_BLANK) ? '_blank' : '_self');

				$item->link = (INSTALL_PATH . $this->items[$id]['link']);

				$item->text = $this->items[$id]['text'];
			}

			return $item;
		}

		# Constructor

		public function __construct() {

			$query = ("SELECT men.id, men.parent_id, men.link, men.text, men.target ") .

					 ("FROM " . TABLE_MENU . " men ORDER BY men.parent_id ASC, men.position ASC, men.id ASC");

			if (!(DB::send($query) && DB::last()->status)) return;

			while (null !== ($item = DB::last()->row())) $this->items[intabs($item['id'])] = [

				'parent_id'     => intabs($item['parent_id']),

				'link'          => strval($item['link']),

				'text'          => strval($item['text']),

				'target'        => intabs($item['target'])
			];

			foreach ($this->items as $id => $item) if (0 === $item['parent_id']) $this->menu[] = $id;

			else if (isset($this->items[$item['parent_id']])) $this->items[$item['parent_id']]['children'][] = $id;
		}

		# Get block

		public function block() {

			$menu = Template::group();

			foreach ($this->menu as $id) $menu->add($this->parseItem($id));

			# ------------------------

			return $menu;
		}
	}
}
