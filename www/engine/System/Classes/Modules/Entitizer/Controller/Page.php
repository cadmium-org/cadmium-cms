<?php

namespace System\Modules\Entitizer\Controller {

	use System\Modules\Entitizer, Arr, DB;

	/**
	 * @property-read int $id
	 * @property-read int $visibility
	 * @property-read int $access
	 * @property-read string $hash
	 * @property-read string $name
	 * @property-read string $title
	 * @property-read string $contents
	 * @property-read string $description
	 * @property-read string $keywrods
	 * @property-read int $robots_index
	 * @property-read int $robots_follow
	 * @property-read int $time_created
	 * @property-read int $time_modified
	 * @property-read array $path
	 * @property-read string $link
	 * @property-read string $canonical
	 */

	class Page extends Entitizer\Utils\Controller {

        # Constructor

		public function __construct($id) {

			$this->entity = Entitizer::page($id);
		}

		# Process post data

		public function process($post) {

			# Declare variables

			$parent_id = null; $title = null; $name = null; $visibility = null; $access = null;

			$description = null; $keywords = null; $robots_index = null; $robots_follow = null; $contents = null;

			# Extract post array

			extract($post);

			# Get hash

			$hash = Arr::encode([$name, Entitizer::page($parent_id)->id]);

			# Check name exists

			if (false === ($check_name = $this->entity->check('hash', $hash))) return 'PAGE_ERROR_MODIFY';

			if ($check_name === 1) return 'PAGE_ERROR_NAME_DUPLICATE';

			# Modify page

			$data = [];

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
			$data['hash']               = $hash;

			$modifier = ((0 === $this->entity->id) ? 'create' : 'edit');

			if (!call_user_func([$this->entity, $modifier], $data)) return 'PAGE_ERROR_MODIFY';

			# ------------------------

			return true;
		}
    }
}
