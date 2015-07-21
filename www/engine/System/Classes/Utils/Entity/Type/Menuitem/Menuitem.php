<?php

namespace System\Utils\Entity\Type {

	class Menuitem extends Definition {

        # Get path

		private function getPath() {

			$id = $this->menuitem['id']; $parent_id = $this->menuitem['parent_id'];

			$text = $this->menuitem['text']; $link = $this->menuitem['link'];

			$path = array($id => array('id' => $id, 'parent_id' => $parent_id, 'text' => $text, 'link' => $link));

			while (0 !== $parent_id) {

				if (key_exists($parent_id, $path)) return false;

				$selection = array('id', 'parent_id', 'link', 'text'); $condition = array('id' => $parent_id);

				if (!(DB::select(TABLE_MENU, $selection, $condition, false, 1) && (DB::last()->rows === 1))) return array();

				$menuitem = DB::last()->row();

				# Validate item

				$id = Number::unsigned($menuitem['id']); $parent_id = Number::unsigned($menuitem['parent_id']);

				$link = String::validate($menuitem['link']); $text = String::validate($menuitem['text']);

				$path[$id] = array('id' => $id, 'parent_id' => $parent_id, 'link' => $link, 'text' => $text);
			}

			# ------------------------

			return array_reverse($path);
		}
    }
}

?>
