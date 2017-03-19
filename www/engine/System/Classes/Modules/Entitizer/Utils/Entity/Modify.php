<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Utils\Entity {

	use Modules\Entitizer, DB;

	trait Modify {

		protected $definition = null, $dataset = null;

		/**
		 * Initialize the subtree connection
		 *
		 * @return bool : true on success or false on failure
		 */

		private function initSubtree() : bool {

			$data = ['ancestor' => $this->id, 'descendant' => $this->id, 'depth' => 0];

			DB::insert(static::$table_relations, $data, false, true);

			# ------------------------

			return (DB::getLast() && DB::getLast()->status);
		}

		/**
		 * Disconnect the subtree from the current position
		 *
		 * @return bool : true on success or false on failure
		 */

		private function disconnectSubtree() : bool {

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

		/**
		 * Connect the subtree under the new position
		 *
		 * @return bool : true on success or false on failure
		 */

		private function connectSubtree(int $parent_id) : bool {

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

		/**
		 * Create the entity entry in DB
		 *
		 * @return bool : true on success or false on failure
		 */

		public function create(array $data) : bool {

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

		/**
		 * Edit the entity entry in DB
		 *
		 * @return bool : true on success or false on failure
		 */

		public function edit(array $data) : bool {

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

		/**
		 * Move the entity to a new parent
		 *
		 * @return bool : true on success or false on failure
		 */

		public function move(int $parent_id) : bool {

			if (0 === $this->id) return false;

			# Re-connect entity if not in tree

			if (!$this->initSubtree()) return false;

			# Get parent entity

			if (0 !== ($parent = Entitizer::get(static::$table, $parent_id))->id) {

				if (false === ($path = $parent->getPath())) return false;

				if (false === ($depth = $this->getSubtreeDepth())) return false;

				if ((count($path) + $depth + 1) > CONFIG_ENTITIZER_MAX_DEPTH) return false;
			}

			# Disconnect subtree from current position

			if (!$this->disconnectSubtree()) return false;

			# Connect subtree under new position

		 	if (0 !== $parent->id) $this->connectSubtree($parent->id);

			# ------------------------

			return true;
		}

		/**
		 * Remove the entity entry from DB
		 *
		 * @return bool : true on success or false on failure
		 */

		public function remove() : bool {

			if (0 === $this->id) return false;

			# Check if entity is removable

			if (static::$super && ($this->id === 1)) return false;

			if (static::$nesting && (0 !== $this->getSubtreeCount())) return false;

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
