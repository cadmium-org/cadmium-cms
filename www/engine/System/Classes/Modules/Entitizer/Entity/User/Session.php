<?php

namespace System\Modules\Entitizer\Entity\User {

	use System\Modules\Entitizer;

	/**
	 * @property-read int $id
	 * @property-read string $code
	 * @property-read string $ip
	 * @property-read int $time
	 */

	class Session extends Entitizer\Utils\Entity {

		use Entitizer\Common\User\Session;

		# Implement entity

		protected function implement() {}
	}
}
