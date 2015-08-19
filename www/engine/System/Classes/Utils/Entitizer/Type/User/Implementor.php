<?php

namespace System\Utils\Entitizer\Type\User {

	class Implementor extends Definition {

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
