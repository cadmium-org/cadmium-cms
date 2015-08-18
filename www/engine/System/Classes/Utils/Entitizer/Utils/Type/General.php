<?php

namespace System\Utils\Entitizer\Utils\Type {

	use System\Utils\Entitizer;

	abstract class General extends Entitizer\Entity {

		protected $super = false, $extensions = array();

		# Init entity by id

		public function initById($id) {

			if (0 !== $this->id) return true;

			if (0 === ($id = intabs($id))) return false;

			# Init entity

			if (!parent::init('id', $id)) return false;

			# ------------------------

			return true;
		}

		# Init entity by unique param

		public function initByUnique($name, $value) {

			if (0 !== $this->id) return true;

			$name = strval($name); $value = strval($value);

			if (false === ($param = $this->params->get($name))) return false;

			if (!($param instanceof Entitizer\Param\Unique)) return false;

			# Init entity

			if (!parent::init($name, $value)) return false;

			# ------------------------

			return true;
		}

		# Remove entity

		public function remove() {

			if (0 === $this->id) return false;

			if ($this->super && ($this->id === 1)) return false;

			# Remove extension entries

			foreach ($this->extensions as $extension) {

				Entitizer::create($extension, $this->id)->remove();
			}

			# Remove entity

			return parent::remove();
		}
	}
}
