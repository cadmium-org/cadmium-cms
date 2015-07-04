<?php

namespace System\Utils\Entity {

	use System\Utils\Lister, DB, Number, String;

	class Menuitem {

		# Errors

		const ERROR_PARENT							= 'MENUITEM_ERROR_PARENT';

		const ERROR_CREATE							= 'MENUITEM_ERROR_CREATE';
		const ERROR_SAVE							= 'MENUITEM_ERROR_SAVE';

		const ERROR_INPUT_TEXT						= 'MENUITEM_ERROR_INPUT_TEXT';
		const ERROR_INPUT_LINK						= 'MENUITEM_ERROR_INPUT_LINK';

		private $menuitem = false, $path = false, $created_id = false;

		# Validate data

		private function validateData($data) {

			$data['id']					= Number::unsigned($data['id']);

			$data['parent_id']			= Number::unsigned($data['parent_id']);

			$data['position']			= Number::unsigned($data['position']);

			$data['link']				= String::validate($data['link']);

			$data['text']				= String::validate($data['text']);

			$data['target']				= Number::unsigned($data['target']);

			# ------------------------

			return $data;
		}

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

		# Init menuitem with id

		public function init($id) {

			if (false !== $this->menuitem) return true;

			if (0 === ($id = Number::unsigned($id))) return false;

			# Select menuitem from DB

			$query = ("SELECT men.id, men.parent_id, men.position, men.link, men.text, men.target ") .

					 ("FROM " . TABLE_MENU . " men WHERE men.id = " . $id . " LIMIT 1");

			if (!(DB::send($query) && (DB::last()->rows === 1))) return false;

			$this->menuitem = $this->validateData(DB::last()->row()); $this->path = $this->getPath();

			# ------------------------

			return true;
		}

		# Create child menuitem

		public function create($data) {

			$parent_id = ((false !== $this->menuitem) ? $this->menuitem['id'] : 0);

			# Check dataset

			$dataset = array('text', 'link');

			foreach ($dataset as $var) if (isset($data[$var])) $$var = $data[$var]; else return false;

			# Check values

			if (false === ($text = String::validate($text))) return self::ERROR_INPUT_TEXT;

			if (false === ($link = String::validate($link))) return self::ERROR_INPUT_LINK;

			# Get position

			DB::select(TABLE_MENU, '(MAX(position) + 1) as position', array('parent_id' => $parent_id));

			if (!DB::last()->status) return self::ERROR_CREATE;

			$position = Number::position(DB::last()->row()['position']);

			# Insert menuitem

			$set['parent_id']			= $parent_id;
			$set['position']			= $position;
			$set['link']				= $link;
			$set['text']				= $text;

			if (!(DB::insert(TABLE_MENU, $set) && (DB::last()->status))) return self::ERROR_CREATE;

			$this->created_id = Number::unsigned(DB::last()->id);

			# ------------------------

			return true;
		}

		# Edit data

		public function edit($data) {

			if (false === $this->menuitem) return false;

			# Check dataset

			$dataset = array('parent_id', 'text', 'link', 'target', 'position');

			foreach ($dataset as $var) if (isset($data[$var])) $$var = $data[$var]; else return false;

			# Check values

			if (false === ($text = String::validate($text))) return self::ERROR_INPUT_TEXT;

			if (false === ($link = String::validate($link))) return self::ERROR_INPUT_LINK;

			# Validate values

			$parent_id = Number::unsigned($parent_id); $target = Lister::target($target, true);

			$position = Number::position($position);

			# Check parent exists

			if (0 !== $parent_id) {

				DB::select(TABLE_MENU, 'id', array('id' => $parent_id), false, 1);

				if (!DB::last()->status) return self::ERROR_SAVE;

				if (DB::last()->rows !== 1) return self::ERROR_PARENT;
			}

			# Update menuitem

			$set['parent_id']			= $parent_id;
			$set['position']			= $position;
			$set['link']				= $link;
			$set['text']				= $text;
			$set['target']				= $target;

			$condition = array('id' => $this->menuitem['id']);

			if (!(DB::update(TABLE_MENU, $set, $condition) && DB::last()->status)) return self::ERROR_SAVE;

			# Init menuitem

			foreach ($set as $name => $value) $this->menuitem[$name] = $value;

			# ------------------------

			return true;
		}

		# Remove menuitem

		public function remove() {

			if (false === $this->menuitem) return false;

			# Count children

			$condition = array('parent_id' => $this->menuitem['id']);

			if (!(DB::select(TABLE_MENU, 'COUNT(*) as count', $condition) && DB::last()->status)) return false;

			if (Number::unsigned(DB::last()->row()['count']) > 0) return false;

			# Remove menuitem

			if (!(DB::delete(TABLE_MENU, array('id' => $this->menuitem['id'])) && DB::last()->status)) return false;

			$this->menuitem = false; $this->path = false;

			# ------------------------

			return true;
		}

		# Return id

		public function id() {

			if (false === $this->menuitem) return false;

			return $this->menuitem['id'];
		}

		# Return parent id

		public function parentId() {

			if (false === $this->menuitem) return false;

			return $this->menuitem['parent_id'];
		}

		# Return text

		public function text() {

			if (false === $this->menuitem) return false;

			return $this->menuitem['text'];
		}

		# Return link

		public function link() {

			if (false === $this->menuitem) return false;

			return $this->menuitem['link'];
		}

		# Return target

		public function target() {

			if (false === $this->menuitem) return false;

			return $this->menuitem['target'];
		}

		# Return position

		public function position() {

			if (false === $this->menuitem) return false;

			return $this->menuitem['position'];
		}

		# Return path

		public function path() {

			return $this->path;
		}

		# Return id of last created child

		public function createdId() {

			return $this->created_id;
		}
	}
}

?>
