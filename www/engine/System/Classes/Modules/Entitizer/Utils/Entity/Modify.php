<?php

namespace Modules\Entitizer\Utils\Entity {

	use Modules\Entitizer, DB;

	trait Modify {

		protected $definition = null, $error = false, $modifiable = false, $data = [];

		# Init entity subtree connection

		private function initSubtree() {

			$dataset = ['ancestor' => $this->id, 'descendant' => $this->id, 'depth' => 0];

			DB::insert(static::$table_relations, $dataset, false, true);

			# ------------------------

			return (DB::last() && DB::last()->status);
		}

		# Disconnect subtree from current position

		private function disconnectSubtree() {

			$query = ("DELETE rla FROM " . static::$table_relations . " rla ") .

			         ("JOIN "  . static::$table_relations . " rlb ON rlb.descendant = rla.descendant ") .

			         ("LEFT JOIN " . static::$table_relations . " rlx ") .

			         ("ON rlx.ancestor = rlb.ancestor AND rlx.descendant = rla.ancestor ") .

			         ("WHERE rlb.ancestor = " . $this->id . " AND rlx.ancestor IS NULL");

			if (!(DB::send($query) && DB::last()->status)) return false;

			# Set path

			$this->data['parent_id'] = 0;

			# ------------------------

			return true;
		}

		# Connect subtree under new position

		private function connectSubtree(int $parent_id) {

			$query = ("INSERT INTO " . static::$table_relations . " (ancestor, descendant, depth) ") .

			         ("SELECT sup.ancestor, sub.descendant, sup.depth + sub.depth + 1 ") .

			         ("FROM " . static::$table_relations . " sup ") .

			         ("JOIN " . static::$table_relations . " sub ") .

			         ("WHERE sub.ancestor = " . $this->id . " AND sup.descendant = " . $parent_id);

			if (!(DB::send($query) && DB::last()->status)) return false;

			# Set path

			$this->data['parent_id'] = $parent_id;

			# ------------------------

			return true;
		}

		# Create entity entry in DB

		public function create(array $data) {

			if (!$this->modifiable || (0 !== $this->id)) return false;

			$data = $this->definition->cast($data);

			if (static::$auto_increment && isset($data['id'])) unset($data['id']);

			# Insert entity

			DB::insert(static::$table, $data);

			if (!(DB::last() && DB::last()->status)) return false;

			# Set data

			$this->error = false;

			if (static::$auto_increment) $this->data['id'] = DB::last()->id;

			foreach ($data as $name => $value) $this->data[$name] = $value;

			# Implement entity

			$this->implement();

			# Init subtreee

			if (static::$nesting) $this->initSubtree();

			# Cache entity

			self::$cache[static::$table][$this->id] = $this;

			# ------------------------

			return true;
		}

		# Edit entity entry in DB

		public function edit(array $data) {

			if (!$this->modifiable || (0 === $this->id)) return false;

			$data = $this->definition->cast($data);

			if (isset($data['id'])) unset($data['id']);

			# Update entity

			DB::update(static::$table, $data, ['id' => $this->id]);

			if (!(DB::last() && DB::last()->status)) return false;

			# Set data

			foreach ($data as $name => $value) $this->data[$name] = $value;

			# Implement entity

			$this->implement();

			# Init subtreee

			if (static::$nesting) $this->initSubtree();

			# ------------------------

			return true;
		}

		# Move entity to new parent

		public function move(int $parent_id) {

			if (!$this->modifiable || (0 === $this->id)) return false;

			# Re-connect entity if not in tree

			if (!$this->initSubtree()) return false;

			# Create parent entity

			if (0 !== ($parent = Entitizer::get(static::$table, $parent_id))->id) {

				if (false === ($path = $parent->path())) return false;

				if (false === ($depth = $this->subtreeDepth())) return false;

				if ((count($path) + $depth + 1) > CONFIG_ENTITIZER_MAX_DEPTH) return false;
			}

			# Disconnect subtree from current position

			if (!$this->disconnectSubtree()) return false;

			# Connect subtree under new position

		 	if (0 !== $parent->id) $this->connectSubtree($parent->id);

			# ------------------------

			return true;
		}
	}
}
