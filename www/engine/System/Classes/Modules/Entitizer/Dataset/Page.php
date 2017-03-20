<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Dataset {

	use Modules\Entitizer, Modules\Settings;

	class Page extends Entitizer\Utils\Dataset {

		use Entitizer\Common\Page;

		/**
		 * Initialize the dataset
		 */

		protected function init() {

			$this->addVirtual('active', function (array $data) {

				return (($data['visibility'] === VISIBILITY_PUBLISHED) && !$data['locked']);
			});

			$this->addVirtual('link', function (array $data) {

				if ('' === $data['slug']) return '';

				return (INSTALL_PATH . '/' . $data['slug']);
			});

			$this->addVirtual('canonical', function (array $data) {

				if ('' === $data['slug']) return '';

				return (Settings::get('system_url') . (($data['id'] !== 1) ? ('/' . $data['slug']) : ''));
			});
		}
	}
}
