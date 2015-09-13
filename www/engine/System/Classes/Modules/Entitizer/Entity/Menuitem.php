<?php

namespace System\Modules\Entitizer\Entity {

	use System\Modules\Entitizer;

	class Menuitem extends Entitizer\Utils\Entity {

		use Entitizer\Common\Menuitem;

		# Implement entity

		protected function implement() {

			$this->data['path'] = $this->getPath();
		}
	}
}
