<?php

namespace System\Modules\Entitizer\Utils {

	abstract class Controller {

		protected $entity = null;

		# Return entity data

		public function __get($name) {

			if (null === $this->entity) return null;

			return $this->entity->$name;
		}
	}
}
