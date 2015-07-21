<?php

namespace System\Utils\Entity\Type {

	class Page extends Definition {

		# Get path

		private function getPath() {

			$id = $this->page['id']; $parent_id = $this->page['parent_id'];

			$name = $this->page['name']; $title = $this->page['title'];

			$path = array($id => array('id' => $id, 'parent_id' => $parent_id, 'name' => $name, 'title' => $title));

			while (0 !== $parent_id) {

				if (key_exists($parent_id, $path)) return false;

				$selection = array('id', 'parent_id', 'name', 'title'); $condition = array('id' => $parent_id);

				if (!(DB::select(TABLE_PAGES, $selection, $condition, false, 1) && (DB::last()->rows === 1))) return array();

				$page = DB::last()->row();

				# Validate item

				$id = Number::unsigned($page['id']); $parent_id = Number::unsigned($page['parent_id']);

				$name = String::validate($page['name']); $title = String::validate($page['title']);

				$path[$id] = array('id' => $id, 'parent_id' => $parent_id, 'name' => $name, 'title' => $title);
			}

			# ------------------------

			return array_reverse($path);
		}
    }
}

?>
