<?php

namespace System\Modules\Entitizer\Entity\User {

	use System\Modules\Entitizer;

	/**
	 * @property-read int $id
	 * @property-read string $code
	 * @property-read string $ip
	 * @property-read int $time
	 */

	class Secret extends Entitizer\Utils\Entity {

		use Entitizer\Common\User\Secret;

		# Implement entity

        protected function implement() {}
    }
}
