<?php

namespace Modules\Entitizer\Controller {

	use Modules\Entitizer, Arr;

	class Page {

		private $page = null;

		# Constructor

		public function __construct(Entitizer\Entity\Page $page) {

			$this->page = $page;
		}

		# Invoker

		public function __invoke(array $post) {

			# Declare variables

			$parent_id = ''; $title = ''; $name = ''; $visibility = ''; $access = '';

			$description = ''; $keywords = ''; $robots_index = ''; $robots_follow = ''; $contents = '';

			# Extract post array

			extract($post);

			# Get hash

			$hash = Arr::encode([$name, Entitizer::get(ENTITY_TYPE_PAGE, $parent_id)->id]);

			# Check name exists

			if (false === ($check_name = $this->page->check('hash', $hash))) return 'PAGE_ERROR_MODIFY';

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

			$modifier = ((0 === $this->page->id) ? 'create' : 'edit');

			if (!$this->page->$modifier($data)) return 'PAGE_ERROR_MODIFY';

			# ------------------------

			return true;
		}
	}
}
