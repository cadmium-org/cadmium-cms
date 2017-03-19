<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Dataset {

	use Modules\Entitizer, Utils\Validate;

	class Menuitem extends Entitizer\Utils\Dataset {

		use Entitizer\Common\Menuitem;

		/**
		 * Initialize the dataset
		 */

		protected function init() {

			$this->addVirtual('link', function (array $data) {

				if ('' === $data['slug']) return '';

				if (false !== Validate::url($data['slug'])) return $data['slug'];

				return (INSTALL_PATH . '/' . $data['slug']);
			});
		}
	}
}
