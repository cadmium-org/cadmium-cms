<?php

namespace Modules\Entitizer\Utils {

	use Modules\Entitizer, DB;

	abstract class Entity extends Cache {

		use Entity\Collection, Entity\Modify;

		protected $definition = null, $dataset = null;

		# Select default entity from DB

		private function selectDefault(string $name, string $value) {

			$selection = array_keys($this->definition->params());

			return DB::select(static::$table, $selection, [$name => $value], null, 1);
		}

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

			$id = $this->definition->param('id')->cast($data['id']);

			# Import data

			if (isset(self::$cache[static::$table][$id])) {

				$this->dataset = self::$cache[static::$table][$id]->dataset;
			}

			# Update data

			$this->dataset->update($data);

			# Cache entity

			self::$cache[static::$table][$this->id] = $this;

			# ------------------------

			return true;
		}

		# Constructor

		public function __construct() {

			# Get definition

			$this->definition = Entitizer::definition(static::$table);

			# Preset data

			$this->dataset = Entitizer::dataset(static::$table);
		}

		# Init entity

		public function init($value, string $name = 'id') {

			if (0 !== $this->id) return false;

			# Get initiation index

			if (false === ($index = $this->definition->index($name))) return false;

			if (($index->type !== 'PRIMARY') && ($index->type !== 'UNIQUE')) return false;

			# Process name & value

			$name = $index->name; $value = $this->definition->param($name)->cast($value);

			# Select entity from DB

			if (!static::$nesting) $this->selectDefault($name, $value); else $this->selectNesting($name, $value);

			# ------------------------

			return ((DB::getLast() && (DB::getLast()->rows === 1)) ? $this->setData(DB::getLast()->getRow()) : false);
		}

		# Check if unique param value exists

		public function check($value, string $name) {

			# Get initiation index

			if (false === ($index = $this->definition->index($name))) return false;

			if ($index->type !== 'UNIQUE') return false;

			# Process name & value

			$name = $index->name; $value = $this->definition->param($name)->cast($value);

			# Select entity from DB

			$condition = ($name . " = '" . addslashes($value) . "' AND id != " . $this->id);

			DB::select(static::$table, 'id', $condition, null, 1);

			# ------------------------

			return ((DB::getLast() && DB::getLast()->status) ? DB::getLast()->rows : false);
		}

		# Return definition

		public function definition() {

			return $this->definition;
		}

		# Return data

		public function data() {

			return $this->dataset->data();
		}

		# Return param value

		public function get(string $name) {

			return $this->dataset->get($name);
		}

		# Getter

		public function __get(string $name) {

			return $this->dataset->get($name);
		}
	}
}
