<?php

namespace System\Modules\Entitizer\Controller {

	use System\Modules\Entitizer;

	class Menuitem extends Entitizer\Utils\Controller {

        # Constructor

		public function __construct($id) {

			$this->entity = Entitizer::menuitem($id);
		}

		# Create menuitem

		public function create($post) {

			if (0 !== $this->entity->id) return true;

			# Declare variables

			$parent_id = null; $text = null; $link = null; $target = null; $position = null;

			# Extract post array

			extract($post);

			# Create menuitem

			$data = array();

			$data['parent_id']          = $parent_id;
			$data['text']               = $text;
			$data['link']               = $link;
			$data['target']             = $target;
			$data['position']           = $position;

			if (!$this->entity->create($data)) return 'MENUITEM_ERROR_CREATE';

			# ------------------------

			return true;
		}

		# Edit menuitem

		public function edit($post) {

			if (0 === $this->entity->id) return false;

			# Declare variables

			$parent_id = null; $text = null; $link = null; $target = null; $position = null;

			# Extract post array

			extract($post);

			# Edit menuitem

			$data = array();

			$data['parent_id']          = $parent_id;
			$data['text']               = $text;
			$data['link']               = $link;
			$data['target']             = $target;
			$data['position']           = $position;

			if (!$this->entity->edit($data)) return 'MENUITEM_ERROR_EDIT';

			# ------------------------

			return true;
		}
	}
}
