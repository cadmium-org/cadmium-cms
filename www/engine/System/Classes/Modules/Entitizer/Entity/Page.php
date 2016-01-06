<?php

namespace Modules\Entitizer\Entity {

	use Modules\Entitizer, Modules\Settings;

	class Page extends Entitizer\Utils\Entity {

		use Entitizer\Common\Page;

		# Get slug

		private function getSlug() {

			return implode('/', array_column($this->data['path'], 'name'));
		}

		# Get link

		private function getLink() {

			if (0 === $this->id) return '';

			return (INSTALL_PATH . '/' . $this->data['slug']);
		}

		# Get canonical

		private function getCanonical() {

			if (0 === $this->id) return '';

			return (Settings::get('system_url') . (($this->id !== 1) ? ('/' . $this->data['slug']) : ''));
		}

		# Implement entity

		protected function implement() {

			$this->data['slug'] = $this->getSlug();

			$this->data['link'] = $this->getLink();

			$this->data['canonical'] = $this->getCanonical();
		}
	}
}
