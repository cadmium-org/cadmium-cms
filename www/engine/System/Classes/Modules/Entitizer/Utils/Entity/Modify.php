<?php

namespace Modules\Entitizer\Utils\Entity {

	use Modules\Entitizer, DB;

	trait Modify {

		protected $definition = null, $dataset = null;

		# Init entity subtree connection

		private function initSubtree() {

			$data = ['ancestor' => $this->id, 'descendant' => $this->id, 'depth' => 0];

			DB::insert(static::$table_relations, $data, false, true);

			# ------------------------

			return (DB::getLast() && DB::getLast()->status);
		}

		# Disconnect subtree from current position

		private function disconnectSubtree() {

			$query = ("DELETE rla FROM " . static::$table_relations . " rla ") .

			         ("JOIN "  . static::$table_relations . " rlb ON rlb.descendant = rla.descendant ") .

			         ("LEFT JOIN " . static::$table_relations . " rlx ") .

			         ("ON rlx.ancestor = rlb.ancestor AND rlx.descendant = rla.ancestor ") .

			         ("WHERE rlb.ancestor = " . $this->id . " AND rlx.ancestor IS NULL");

			if (!(DB::send($query) && DB::getLast()->status)) return false;

			# Set path

			$this->dataset->update(['parent_id' => 0]);

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

			if (!(DB::send($query) && (DB::getLast()->rows > 0))) return false;

			# Set path

			$this->dataset->update(['parent_id' => $parent_id]);

			# ------------------------

			return true;
		}

		# Create entity entry in DB

		public function create(array $data) {

			if (0 !== $this->id) return false;

			$data = $this->dataset->cast($data);

			if (static::$auto_increment && isset($data['id'])) $data['id'] = 0;

			# Insert entity

			DB::insert(static::$table, $data);

			if (!(DB::getLast() && DB::getLast()->status)) return false;

			# Update data

			if (static::$auto_increment) $data['id'] = DB::getLast()->id;

			$this->dataset->update($data);

			# Init subtreee

			if (static::$nesting) $this->initSubtree();

			# Cache entity

			self::$cache[static::$table][$this->id] = $this;

			# ------------------------

			return true;
		}

		# Edit entity entry in DB

		public function edit(array $data) {

			if (0 === $this->id) return false;

			$data = $this->dataset->cast($data);

			if (isset($data['id'])) unset($data['id']);

			# Update entity

			DB::update(static::$table, $data, ['id' => $this->id]);

			if (!(DB::getLast() && DB::getLast()->status)) return false;

			# Update data

			$this->dataset->update($data);

			# Init subtreee

			if (static::$nesting) $this->initSubtree();

			# ------------------------

			return true;
		}

		# Move entity to new parent

		public function move(int $parent_id) {

			if (0 === $this->id) return false;

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

		# Remove entity entry from DB

		public function remove() {

			if (0 === $this->id) return false;

			# Check if entity is removable

			if (static::$super && ($this->id === 1)) return false;

			if (static::$nesting && (0 !== $this->subtreeCount())) return false;

			# Remove entity

			DB::delete(static::$table, ['id' => $this->id]);

			if (!(DB::getLast() && DB::getLast()->status)) return false;

			# Uncache entity

			unset(self::$cache[static::$table][$this->id]);

			# Reset data

			$this->dataset->reset();

			# ------------------------

			return true;
		}
	}
}
