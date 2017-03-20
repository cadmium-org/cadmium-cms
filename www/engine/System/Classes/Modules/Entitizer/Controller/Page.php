<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Controller {

	use Modules\Entitizer;

	class Page {

		private $page = null;

		/**
		 * Constructor
		 */

		public function __construct(Entitizer\Entity\Page $page) {

			$this->page = $page;
		}

		/**
		 * Invoker
		 *
		 * @return true|string : true on success or an error code on failure
		 */

		public function __invoke(array $post) {

			# Declare variables

			$title = ''; $name = ''; $visibility = ''; $access = '';

			$description = ''; $keywords = ''; $robots_index = ''; $robots_follow = ''; $contents = '';

			# Extract post array

			extract($post);

			# Modify page

			$data = [];

			$data['title']              = $title;
			$data['name']               = $name;
			$data['visibility']         = $visibility;
			$data['access']             = $access;
			$data['description']        = $description;
			$data['keywords']           = $keywords;
			$data['robots_index']       = $robots_index;
			$data['robots_follow']      = $robots_follow;
			$data['contents']           = $contents;
			$data['time_modified']      = REQUEST_TIME;

			if (0 === $this->page->id) $data['time_created'] = REQUEST_TIME;

			$modifier = ((0 === $this->page->id) ? 'create' : 'edit');

			if (!$this->page->$modifier($data)) return 'PAGE_ERROR_MODIFY';

			# ------------------------

			return true;
		}
	}
}
