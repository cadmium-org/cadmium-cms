<?php

namespace System\Modules\Entitizer\Controller {

	use System\Modules\Entitizer;

	/**
	 * @property-read int $id
	 * @property-read int $position
	 * @property-read string $link
	 * @property-read string $text
	 * @property-read int $target
	 * @property-read array $path
	 */

	class Menuitem extends Entitizer\Utils\Controller {

		# Constructor

		public function __construct($id) {

			$this->entity = Entitizer::menuitem($id);
		}

		# Process post data

		public function process($post) {

			# Declare variables

			$parent_id = null; $text = null; $link = null; $target = null; $position = null;

			# Extract post array

			extract($post);

			# Modify menuitem

			$data = [];

			$data['parent_id']          = $parent_id;
			$data['text']               = $text;
			$data['link']               = $link;
			$data['target']             = $target;
			$data['position']           = $position;

			$modifier = ((0 === $this->entity->id) ? 'create' : 'edit');

			if (!call_user_func([$this->entity, $modifier], $data)) return 'MENUITEM_ERROR_MODIFY';

			# ------------------------

			return true;
		}
	}
}
