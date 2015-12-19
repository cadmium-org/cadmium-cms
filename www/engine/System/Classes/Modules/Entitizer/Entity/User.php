<?php

namespace System\Modules\Entitizer\Entity {

	use System\Modules\Entitizer;

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
