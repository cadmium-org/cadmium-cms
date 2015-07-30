<?php

namespace System\Utils\Entity\Type\Menuitem {

	use System\Utils\Entity, DB, Form, Number;

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

			foreach ($fields as $field) if (isset($fieldset[$field]) && ($fieldset[$field] instanceof Form\Utils\Field))

				$$field = $fieldset[$field]->value(); else return false;

			# Get position

			$parent_id = ((false !== $this->entity->id) ? $this->entity->id : 0);

			DB::select(TABLE_MENU, '(MAX(position) + 1) as position', array('parent_id' => $parent_id));

			if (!DB::last()->status) return self::ERROR_CREATE;

			$position = Number::position(DB::last()->row()['position']);

			# Insert menuitem

			$data['text']               = $text;
			$data['link']               = $link;
			$data['position']           = $position;

			if (!$this->entity->create($data)) return self::ERROR_CREATE;

			# ------------------------

			return true;
		}

		# Edit page

		public function edit($fieldset) {

			if (false === $this->entity->id) return false;

			# Check fieldset

			$fields = array('parent_id', 'text', 'link', 'target', 'position');

			foreach ($fields as $field) if (isset($fieldset[$field]) && ($fieldset[$field] instanceof Form\Utils\Field))

				$$field = $fieldset[$field]->value(); else return false;

			# Update menuitem

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
