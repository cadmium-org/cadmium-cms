<?php

namespace System\Utils\Entitizer\Type\Menuitem {

	use System\Utils\Entitizer, DB, Number;

	/**
	 * @property-read int $id
	 * @property-read int $created_id
	 * @property-read int $parent_id
	 * @property-read int $position
	 * @property-read string $link
	 * @property-read string $text
	 * @property-read int $target
	 * @property-read array $path
	 */

	class Manager extends Entitizer\Utils\Manager {

		# Errors

		const ERROR_CREATE                  = 'MENUITEM_ERROR_CREATE';
		const ERROR_EDIT                    = 'MENUITEM_ERROR_EDIT';

        # Constructor

		public function __construct($id) {

			$this->entity = Entitizer::menuitem($id);
		}

		# Create child menuitem

		public function createChild($post) {

			# Declare variables

			$text = null; $link = null;

			# Extract post array

			extract($post);

			# Get position

			DB::select(TABLE_MENU, '(MAX(position) + 1) as position', array('parent_id' => $this->entity->id));

			if (!DB::last()->status) return self::ERROR_CREATE;

			$position = Number::format(DB::last()->row()['position'], 0, 99);

			# Insert menuitem

			$data = array();

			$data['text']               = $text;
			$data['link']               = $link;
			$data['position']           = $position;

			if (false === ($child = $this->entity->createChild($data))) return self::ERROR_CREATE;

			# ------------------------

			return $child;
		}

		# Edit page

		public function edit($post) {

			if (0 === $this->entity->id) return false;

			# Declare variables

			$parent_id = null; $text = null; $link = null; $target = null; $position = null;

			# Extract post array

			extract($post);

			# Update menuitem

			$data = array();

			$data['parent_id']          = $parent_id;
			$data['text']               = $text;
			$data['link']               = $link;
			$data['target']             = $target;
			$data['position']           = $position;

			if (!$this->entity->edit($data)) return self::ERROR_EDIT;

			# ------------------------

			return true;
		}
	}
}
