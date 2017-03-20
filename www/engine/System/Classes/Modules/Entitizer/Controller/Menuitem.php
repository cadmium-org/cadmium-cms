<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Controller {

	use Modules\Entitizer;

	class Menuitem {

		private $menuitem = null;

		/**
		 * Constructor
		 */

		public function __construct(Entitizer\Entity\Menuitem $menuitem) {

			$this->menuitem = $menuitem;
		}

		/**
		 * Invoker
		 *
		 * @return true|string : true on success or an error code on failure
		 */

		public function __invoke(array $post) {

			# Declare variables

			$text = ''; $slug = ''; $target = ''; $active = ''; $position = '';

			# Extract post array

			extract($post);

			# Modify menuitem

			$data = [];

			$data['text']               = $text;
			$data['slug']               = $slug;
			$data['target']             = $target;
			$data['active']             = $active;
			$data['position']           = $position;

			$modifier = ((0 === $this->menuitem->id) ? 'create' : 'edit');

			if (!$this->menuitem->$modifier($data)) return 'MENUITEM_ERROR_MODIFY';

			# ------------------------

			return true;
		}
	}
}
