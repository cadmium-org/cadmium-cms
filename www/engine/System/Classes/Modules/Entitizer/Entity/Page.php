<?php

namespace System\Modules\Entitizer\Entity {

	use System\Modules\Entitizer;

	class Page extends Entitizer\Utils\Entity {

		use Entitizer\Common\Page;

		# Get link

		private function getLink() {

			return ((0 !== $this->id) ? ('/' . implode('/', array_column($this->data['path'], 'name'))) : '');
		}

		# Get canonical

		private function getCanonical() {

			return ((0 !== $this->id) ? (($this->id !== 1) ? $this->data['link'] : '') : '');
		}

		# Implement entity

		protected function implement() {

			$this->data['link'] = $this->getLink();

			$this->data['canonical'] = $this->getCanonical();
		}
	}
}
