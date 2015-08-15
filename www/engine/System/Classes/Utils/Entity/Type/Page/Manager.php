<?php

namespace System\Utils\Entity\Type\Page {

	use System\Utils\Entity, DB;

	/**
	 * @property-read int $id
	 * @property-read int $created_id
	 * @property-read int $parent_id
	 * @property-read int $visibility
	 * @property-read int $access
	 * @property-read string $name
	 * @property-read string $title
	 * @property-read string $contents
	 * @property-read string $description
	 * @property-read string $keywords
	 * @property-read int $robots_index
	 * @property-read int $robots_follow
	 * @property-read int $time_created
	 * @property-read int $time_modified
	 * @property-read array $path
	 * @property-read string $link
	 * @property-read string $canonical
	 */

	class Manager extends Entity\Utils\Manager {

		# Errors

		const ERROR_CREATE                  = 'PAGE_ERROR_CREATE';
		const ERROR_EDIT                    = 'PAGE_ERROR_EDIT';

		const ERROR_NAME_DUPLICATE          = 'PAGE_ERROR_NAME_DUPLICATE';

        # Constructor

		public function __construct($id) {

			$this->entity = Entity\Factory::page($id);
		}

		# Create child page

		public function create($post) {

			# Declare variables

			$title = null; $name = null;

			# Extract post array

			extract($post);

			# Check name exists

			$condition = ("name = '" . addslashes($name) . "' AND parent_id = " . $this->entity->id);

			DB::select(TABLE_PAGES, 'id', $condition, null, 1);

			if (!DB::last()->status) return self::ERROR_CREATE;

			if (DB::last()->rows === 1) return self::ERROR_NAME_DUPLICATE;

			# Create page

			$data = array();

			$data['title']              = $title;
			$data['name']               = $name;

			if (!$this->entity->create($data)) return self::ERROR_CREATE;

			# ------------------------

			return true;
		}

		# Edit page

		public function edit($post) {

			if (0 === $this->entity->id) return false;

			# Declare variables

			$parent_id = null; $title = null; $name = null; $visibility = null; $access = null;

			$description = null; $keywords = null; $robots_index = null; $robots_follow = null; $contents = null;

			# Extract post array

			extract($post);

			# Check name exists

			$condition = ("name = '" . addslashes($name) . "' AND parent_id = " . $parent_id . " AND id != " . $this->entity->id);

			DB::select(TABLE_PAGES, 'id', $condition, null, 1);

			if (!DB::last()->status) return self::ERROR_EDIT;

			if (DB::last()->rows === 1) return self::ERROR_NAME_DUPLICATE;

			# Edit page

			$data = array();

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
