<?php

namespace Modules\Entitizer\Utils {

	use Modules\Entitizer, DB;

	abstract class Entity extends Cache {

		use Entity\Modify, Entity\Remove, Entity\View;

		protected $definition = null, $error = false, $modifiable = false, $data = [];

		# Select nesting entity from DB

		private function selectNesting(string $name, string $value) {

			# Process selection

			$selection = array_keys($this->definition->params());

			foreach ($selection as $key => $field) $selection[$key] = ('ent.' . $field);

			# Process query

			$query = ("SELECT " . implode(', ', $selection) .", rel.ancestor as parent_id ") .

			         ("FROM " . static::$table . " ent ") .

			         ("LEFT JOIN " . static::$table_relations . " rel ON rel.descendant = ent.id AND rel.depth = 1 ") .

			         ("WHERE ent." . $name . " = '" . addslashes($value) . "' LIMIT 1");

			# ------------------------

			return DB::send($query);
		}

		# Set selected data

		protected function setData(array $data) {

			# Set data

			$this->data = $this->definition->cast($data, true);

			if (static::$nesting) $this->data['parent_id'] = intval($data['parent_id'] ?? 0);

			# Implement entity

			$this->implement();

			# Cache entity

			self::$cache[static::$table][$this->id] = $this;

			# ------------------------

			return true;
		}

		# Constructor

		public function __construct(array $data = []) {

			# Get definition

			$this->definition = Entitizer::definition(static::$table);

			# Check data

			if ([] === $data) $this->modifiable = true;

			# Preset data

			$this->data = $this->definition->cast($data, true);

			# Preset parent id

			if (static::$nesting) $this->data['parent_id'] = 0;

			# Implement entity

			$this->implement();
		}

		# Init entity

		public function init($value, string $name = 'id') {

			if (!$this->modifiable || (0 !== $this->id)) return false;

			# Get initiation index

			if (false === ($index = $this->definition->index($name))) return false;

			if (($index->type !== 'PRIMARY') && ($index->type !== 'UNIQUE')) return false;

			# Process name & value

			$name = $index->name; $value = $this->definition->param($name)->cast($value);

			# Select entity from DB

			if (static::$nesting) $this->selectNesting($name, $value); else {

				$selection = array_keys($this->definition->params());

				DB::select(static::$table, $selection, [$name => $value], null, 1);
			}

			if (($this->error = !(DB::last() && DB::last()->status)) || (DB::last()->rows !== 1)) return false;

			# ------------------------

			return $this->setData(DB::last()->row());
		}

		# Check if unique param value exists

		public function check($value, string $name) {

			if (!$this->modifiable) return false;

			# Get initiation index

			if (false === ($index = $this->definition->index($name))) return false;

			if ($index->type !== 'UNIQUE') return false;

			# Process name & value

			$name = $index->name; $value = $this->definition->param($name)->cast($value);

			# Select entity from DB

			$condition = ($name . " = '" . addslashes($value) . "' AND id != " . $this->id);

			DB::select(static::$table, 'id', $condition, null, 1);

			# ------------------------

			return ((DB::last() && DB::last()->status) ? DB::last()->rows : false);
		}

		# Check for init errors

		public function error() {

			return $this->error;
		}

		# Check if modifiable

		public function modifiable() {

			return $this->modifiable;
		}

		# Return data

		public function data() {

			return $this->data;
		}

		# Return param value

		public function get(string $name) {

			return ($this->data[$name] ?? null);
		}

		# Getter

		public function __get(string $name) {

			return $this->get($name);
		}
	}
}
