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

		# Check if name available

		public function checkName($name) {

			$name = strval($name);

			$condition = ("name = '" . addslashes($name) . "' AND id != " . $this->id);

			DB::select(TABLE_USERS, 'id', $condition, null, 1);

			return ((DB::last() && DB::last()->status) ? DB::last()->rows : false);
		}

		# Check if email available

		public function checkEmail($email) {

			$email = strval($email);

			$condition = ("email = '" . addslashes($email) . "' AND id != " . $this->id);

			DB::select(TABLE_USERS, 'id', $condition, null, 1);

			return ((DB::last() && DB::last()->status) ? DB::last()->rows : false);
		}
	}
}
