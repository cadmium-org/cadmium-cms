<?php

namespace System\Modules\Entitizer\Entity {

	use System\Modules\Entitizer;

	class User extends Entitizer\Utils\Entity {

		use Entitizer\Common\User;

		# Get full name

		private function getFullName() {

			return trim($this->data['first_name'] . ' ' . $this->data['last_name']);
		}

		# Check if unique field value is available

		private function checkUnique($field, $value) {

			$value = strval($value);

			$condition = ($field . " = '" . addslashes($value) . "' AND id != " . $this->id);

			DB::select(TABLE_USERS, 'id', $condition, null, 1);

			# ------------------------

			return ((DB::last() && DB::last()->status) ? DB::last()->rows : false);
		}

        # Implement entity

        protected function implement() {

            $this->data['full_name'] = $this->getFullName();
        }

		# Check if name available

		public function checkName($name) {

			return $this->checkUnique('name', $name);
		}

		# Check if email available

		public function checkEmail($email) {

			return $this->checkUnique('email', $email);
		}
	}
}
