<?php

namespace Modules\Entitizer\Dataset {

	use Modules\Entitizer;

	class User extends Entitizer\Utils\Dataset {

		use Entitizer\Common\User;

		# Init dataset

		protected function init() {

			$this->addWorker('gravatar', function (array $data) {

				return md5(strtolower($data['email']));
			});

			$this->addWorker('full_name', function (array $data) {

				return trim($data['first_name'] . ' ' . $data['last_name']);
			});
		}
	}
}
