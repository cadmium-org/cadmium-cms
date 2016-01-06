<?php

namespace Modules\Entitizer\Entity {

	use Modules\Entitizer, Validate;

	class Menuitem extends Entitizer\Utils\Entity {

		use Entitizer\Common\Menuitem;

		# Get link

		private function getLink() {

			if ('' === $this->data['slug']) return '';

			if (false !== Validate::url($this->data['slug'])) return $this->data['slug'];

			# ------------------------

			return (INSTALL_PATH . '/' . $this->data['slug']);
		}

		# Implement entity

		protected function implement() {

			$this->data['link'] = $this->getLink();
		}
	}
}
