<?php

namespace System\Modules\Entitizer\Entity {

	use System\Modules\Entitizer;

	/**
	 * @property-read int $id
	 * @property-read int $rank
	 * @property-read string $name
	 * @property-read string $email
	 * @property-read string $auth_key
	 * @property-read string $password
	 * @property-read string $first_name
	 * @property-read string $last_name
	 * @property-read int $sex
	 * @property-read string $city
	 * @property-read string $country
	 * @property-read string $timezone
	 * @property-read int $time_registered
	 * @property-read int $time_logged
	 * @property-read string $full_name
	 */

	class User extends Entitizer\Utils\Entity {

		use Entitizer\Common\User;

		# Get full name

		private function getFullName() {

			return trim($this->data['first_name'] . ' ' . $this->data['last_name']);
		}

		# Implement entity

		protected function implement() {

			$this->data['full_name'] = $this->getFullName();
		}
	}
}
