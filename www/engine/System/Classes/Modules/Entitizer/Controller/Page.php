<?php

namespace System\Modules\Entitizer\Controller {

	use System\Modules\Entitizer, DB;

	class Page extends Entitizer\Utils\Controller {

        # Constructor

		public function __construct($id) {

			$this->entity = Entitizer::page($id);
		}

		# Create page

		public function create($post) {

			if (0 !== $this->entity->id) return true;

			# Declare variables

			$parent_id = null; $title = null; $name = null; $visibility = null; $access = null;

			$description = null; $keywords = null; $robots_index = null; $robots_follow = null; $contents = null;

			# Extract post array

			extract($post);

			# Check name exists

			$condition = ("name = '" . addslashes($name) . "' AND parent_id = " . $this->entity->id);

			DB::select(TABLE_PAGES, 'id', $condition, null, 1);

			if (!DB::last()->status) return 'PAGE_ERROR_CREATE';

			if (DB::last()->rows === 1) return 'PAGE_ERROR_NAME_DUPLICATE';

			# Create page

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

			if (!$this->entity->create($data)) return 'PAGE_ERROR_CREATE';

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

			if (!DB::last()->status) return 'PAGE_ERROR_EDIT';

			if (DB::last()->rows === 1) return 'PAGE_ERROR_NAME_DUPLICATE';

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

			if (!$this->entity->edit($data)) return 'PAGE_ERROR_EDIT';

			# ------------------------

			return true;
		}
    }
}
