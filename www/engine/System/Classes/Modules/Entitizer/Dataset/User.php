<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Dataset {

	use Modules\Entitizer;

	class User extends Entitizer\Utils\Dataset {

		use Entitizer\Common\User;

		/**
		 * Initialize the dataset
		 */

		protected function init() {

			$this->addVirtual('gravatar', function (array $data) {

				return md5(strtolower($data['email']));
			});

			$this->addVirtual('full_name', function (array $data) {

				return trim($data['first_name'] . ' ' . $data['last_name']);
			});
		}
	}
}
