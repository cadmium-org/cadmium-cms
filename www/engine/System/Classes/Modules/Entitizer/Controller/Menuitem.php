<?php

namespace System\Modules\Entitizer\Controller {

	use System\Modules\Entitizer;

	class Menuitem {

		private $menuitem = null;

		# Constructor

		public function __construct(Entitizer\Entity\Menuitem $menuitem) {

			$this->menuitem = $menuitem;
		}

		# Invoker

		public function __invoke(array $post) {

			# Declare variables

			$parent_id = ''; $text = ''; $link = ''; $target = ''; $position = '';

			# Extract post array

			extract($post);

			# Modify menuitem

			$data = [];

			$data['parent_id']          = $parent_id;
			$data['text']               = $text;
			$data['link']               = $link;
			$data['target']             = $target;
			$data['position']           = $position;

			$modifier = ((0 === $this->menuitem->id) ? 'create' : 'edit');

			if (!$this->menuitem->$modifier($data)) return 'MENUITEM_ERROR_MODIFY';

			# ------------------------

			return true;
		}
	}
}
