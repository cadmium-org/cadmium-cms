<?php

namespace Modules\Entitizer\Utils\Entity {

	use Modules\Entitizer, DB;

	trait Remove {

		protected $definition = null, $error = false, $modifiable = false, $data = [];

		# Remove entity entry from DB

		public function remove() {

			if (!$this->modifiable || (0 === $this->id)) return false;

			# Check if entity is removable

			if (static::$super && ($this->id === 1)) return false;

			if (static::$nesting && (0 !== $this->subtreeCount())) return false;

			# Remove entity

			DB::delete(static::$table, ['id' => $this->id]);

			if (!(DB::last() && DB::last()->status)) return false;

			# Uncache entity

			if ((self::$cache[static::$table][$this->id] ?? null) === $this) {

				unset(self::$cache[static::$table][$this->id]);
			}

			# Reset data

			$this->data = $this->definition->cast([], true);

			if (static::$nesting) $this->data['parent_id'] = 0;

			# Implement entity

			$this->implement();

			# ------------------------

			return true;
		}
	}
}
