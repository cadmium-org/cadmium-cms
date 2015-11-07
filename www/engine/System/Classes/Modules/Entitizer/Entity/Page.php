<?php

namespace System\Modules\Entitizer\Entity {

	use System\Modules\Entitizer;

	/**
	 * @property-read int $id
	 * @property-read int $visibility
	 * @property-read int $access
	 * @property-read string $hash
	 * @property-read string $name
	 * @property-read string $title
	 * @property-read string $contents
	 * @property-read string $description
	 * @property-read string $keywrods
	 * @property-read int $robots_index
	 * @property-read int $robots_follow
	 * @property-read int $time_created
	 * @property-read int $time_modified
	 * @property-read array $path
	 * @property-read string $link
	 * @property-read string $canonical
	 */

	class Page extends Entitizer\Utils\Entity {

		use Entitizer\Common\Page;

		# Get link

		private function getLink() {

			return (($this->id !== 0) ? ('/' . implode('/', array_column($this->data['path'], 'name'))) : '');
		}

		# Get canonical

		private function getCanonical() {

			return (($this->id !== 0) ? (($this->id !== 1) ? $this->data['link'] : '') : '');
		}

		# Implement entity

		protected function implement() {

			$this->data['link'] = $this->getLink();

			$this->data['canonical'] = $this->getCanonical();
		}
	}
}
