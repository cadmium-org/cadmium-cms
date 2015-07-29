<?php

namespace System\Utils\Entity\Type\Page {

	use System\Utils\Entity, DB, Form;

	class Manager extends Entity\Manager {

		# Errors

		const ERROR_CREATE                  = 'PAGE_ERROR_CREATE';
		const ERROR_EDIT                    = 'PAGE_ERROR_EDIT';

		const ERROR_NAME_DUPLICATE          = 'PAGE_ERROR_NAME_DUPLICATE';

        # Constructor

		public function __construct($id) {

			$this->entity = Entity\Factory::page($id);
		}

		# Create child page

		public function create($fieldset) {

			# Check fieldset

			$fields = array('title', 'name');

			foreach ($fields as $field) if (isset($fieldset[$field]) && ($fieldset[$field] instanceof Form\Utils\Field))

				$$field = $fieldset[$field]->value(); else return false;

			# Check name exists

			$parent_id = ((false !== $this->entity->id) ? $this->entity->id : 0);

			$condition = ("name = '" . addslashes($name) . "' AND parent_id = " . $parent_id);

			DB::select(TABLE_PAGES, 'id', $condition, false, 1);

			if (!DB::last()->status) return self::ERROR_CREATE;

			if (DB::last()->rows === 1) return self::ERROR_NAME_DUPLICATE;

			# Create page

			$data['title']              = $title;
			$data['name']               = $name;

			if (!$this->entity->create($data)) return self::ERROR_CREATE;

			# ------------------------

			return true;
		}

		# Edit page

		public function edit($fieldset) {

			if (false === $this->entity->id) return false;

			# Check fieldset

			$fields = array('parent_id', 'title', 'name', 'visibility', 'access',

			                'description', 'keywords', 'robots_index', 'robots_follow', 'contents');

			foreach ($fields as $field) if (isset($fieldset[$field]) && ($fieldset[$field] instanceof Form\Utils\Field))

				 $$field = $fieldset[$field]->value(); else return false;

			# Check name exists

			$condition = ("name = '" . addslashes($name) . "' AND parent_id = " . $parent_id . " AND id != " . $this->entity->id);

			DB::select(TABLE_PAGES, 'id', $condition, false, 1);

			if (!DB::last()->status) return self::ERROR_EDIT;

			if (DB::last()->rows === 1) return self::ERROR_NAME_DUPLICATE;

			# Edit page

			$data['parent_id']          = $parent_id;
			$data['title']              = $title;
			$data['name']               = $name;
			$data['visibility']         = $visibility;
			$data['access']             = $access;
			$data['description']        = $description;
			$data['keywords']           = $keywords;
			$data['robots_index']       = $robots_index;
			$data['robots_follow']      = $robots_follow;
			$data['contents']           = $contents;

			if (!$this->entity->edit($data)) return self::ERROR_EDIT;

			# ------------------------

			return true;
		}
    }
}

?>
