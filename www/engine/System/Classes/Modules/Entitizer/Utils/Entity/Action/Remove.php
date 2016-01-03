<?php

namespace System\Modules\Entitizer\Utils\Entity\Action {

	use DB;

	trait Remove {

		protected $definition = null, $error = false, $id = 0, $data = [];

		# Remove entity entry from DB

		public function remove() {

			if (0 === $this->id) return false;

			# Check if entity is removable

			if (static::$super && ($this->id === 1)) return false;

			if (static::$nesting && (0 !== $this->children())) return false;

			# Remove extension entries

			foreach (static::$extensions as $extension) {

				$entity = self::get($extension, $this->id);

				if ($entity->error() || ((0 !== $entity->id) && !$entity->remove())) return false;
			}

			# Remove entity

			DB::delete(static::$table, ['id' => $this->id]);

			if (!(DB::last() && DB::last()->status)) return false;

			# Uncache entity

			if (self::$cache[static::$type][$this->id] === $this) unset(self::$cache[static::$type][$this->id]);

			# Reset id

			$this->id = 0;

			# Reset data array

			foreach ($this->definition->params() as $name => $param) $this->data[$name] = $param->cast(null);

			# Reset path

			if (static::$nesting) $this->data['path'] = [];

			# Implement entity

			$this->implement();

			# ------------------------

			return true;
		}

		# Get dataset interface

		abstract protected function children();

		# Implementor interface

		abstract protected function implement();
	}
}
