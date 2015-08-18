<?php

namespace System\Utils\Entitizer\Utils\Type {

	use System\Utils\Entitizer;

	abstract class Extension extends Entitizer\Entity {

		protected $parent = '';

		# Init entity by id

		public function initById($id) {

			if (0 !== $this->id) return true;

			if (0 === ($id = intabs($id))) return false;

			$this->id = Entitizer::create($this->parent, $id)->id;

			# ------------------------

			return $this->init('id', $this->id);
		}
	}
}
