<?php

namespace System\Utils {

	use DB, Number, String, Template;

	class Menu {

		private $items = array(), $menu = array();

		# Parse item

		private function parseItem($id) {

			if (isset($this->items[$id]['children'])) {

				$item = Template::block('Menu/Container');

				$item->text = $this->items[$id]['text'];

				$item->children = ($children = Template::group());

				foreach ($this->items[$id]['children'] as $child) $children->add($this->parseItem($child));

			} else {

				$item = Template::block('Menu/Item');

				$item->link = $this->items[$id]['link'];

				$item->text = $this->items[$id]['text'];
			}

			return $item;
		}

		# Constructor

		public function __construct() {

			$query = ("SELECT men.id, men.parent_id, men.link, men.text, men.target ") .

					 ("FROM " . TABLE_MENU . " men ORDER BY men.parent_id ASC, men.position ASC, men.id ASC");

			if (!(DB::send($query) && DB::last()->status)) return;

			while (null !== ($item = DB::last()->row())) $this->items[Number::unsigned($item['id'])] = array (

				'parent_id'		=> Number::unsigned($item['parent_id']),

				'link'			=> String::validate($item['link']),

				'text'			=> String::validate($item['text']),

				'target'		=> Lister::target($item['target'], true)
			);

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
