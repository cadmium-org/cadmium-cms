<?php

namespace System\Modules\Entitizer\Entity {

	use System\Modules\Entitizer, Arr;

	class Page extends Entitizer\Utils\Entity {

		use Entitizer\Common\Page;

		# Get link

		private function getLink() {

			return ('/' . implode('/', Arr::subvalExtract($this->data['path'], 'name')));
		}

		# Get canonical

		private function getCanonical() {

			return (($this->id !== 1) ? $this->data['link'] : '');
		}

		# Implement entity

		protected function implement() {

			$this->data['link'] = $this->getLink();

			$this->data['canonical'] = $this->getCanonical();
		}
    }
}
