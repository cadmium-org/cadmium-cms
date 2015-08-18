<?php

namespace System\Utils\Entitizer\Utils\Type {

	use System\Utils\Entitizer, DB;

	abstract class Nesting extends General {

		protected $path = array();

		# Init parent entities

		private function initPath() {

			$entity = $this; $path = array($entity);

			while (0 !== $entity->data['parent_id']) {

				$entity = $entity->relation('parent_id');

				if (0 !== $entity->id) $path[] = $entity; else return array();
			}

			return array_reverse($path);
		}

		# Init entity by id

		public function initById($id) {

			if (!parent::initById($id)) return false;

			# Init path

			$this->path = $this->initPath();

			# ------------------------

			return true;
		}

		# Init entity by unique param

		public function initByUnique($name, $value) {

            if (!parent::initByUnique($name, $value)) return false;

			# Init path

			$this->path = $this->initPath();

			# ------------------------

			return true;
		}

		# Remove entity

		public function remove() {

			if (0 === $this->id) return false;

			# Count children

			DB::select($this->table, 'COUNT(*) as count', array('parent_id' => $this->id));

			if (!(DB::last() && DB::last()->status)) return false;

			if (intabs(DB::last()->row()['count']) > 0) return false;

			# Remove entity

			if (!parent::remove()) return false;

			$this->path = array();

			# ------------------------

			return true;
		}

		# Create child entity

		public function createChild(array $data) {

			$child = Entitizer::create($this->type);

			$child->params->get('parent_id')->set($this->id);

			if (!$child->create($data)) return false;

			# ------------------------

			return $child;
		}
	}
}
