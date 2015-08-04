<?php

namespace System\Utils\Entity\Type\Menuitem {

	use System\Utils\Entity, DB, Form, Number;

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

	class Manager extends Entity\Manager {

		# Errors

		const ERROR_CREATE                  = 'MENUITEM_ERROR_CREATE';
		const ERROR_EDIT                    = 'MENUITEM_ERROR_EDIT';

        # Constructor

		public function __construct($id) {

			$this->entity = Entity\Factory::menuitem($id);
		}

		# Create child menuitem

		public function create($fieldset) {

			# Check fieldset

			$fields = array('text', 'link');

			foreach ($fields as $field) if (isset($fieldset[$field])) $$field = $fieldset[$field]; else return false;

			# Get position

			DB::select(TABLE_MENU, '(MAX(position) + 1) as position', array('parent_id' => $this->entity->id));

			if (!DB::last()->status) return self::ERROR_CREATE;

			$position = Number::format(DB::last()->row()['position'], 0, 99);

			# Insert menuitem

			$data = array();

			$data['text']               = $text;
			$data['link']               = $link;
			$data['position']           = $position;

			if (!$this->entity->create($data)) return self::ERROR_CREATE;

			# ------------------------

			return true;
		}

		# Edit page

		public function edit($fieldset) {

			if (0 === $this->entity->id) return false;

			# Check fieldset

			$fields = array('parent_id', 'text', 'link', 'target', 'position');

			foreach ($fields as $field) if (isset($fieldset[$field])) $$field = $fieldset[$field]; else return false;

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
