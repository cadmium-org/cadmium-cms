<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Utils {

	use Modules\Entitizer, DB;

	abstract class Entity extends Cache {

		use Entity\Collection, Entity\Modify;

		protected $definition = null, $dataset = null;

		/**
		 * Select a basic entity from DB
		 *
		 * @return DB\Result|false : the selection result object or false on failure
		 */

		private function selectBasic(string $name, string $value) {

			$selection = array_keys($this->definition->getParams());

			return DB::select(static::$table, $selection, [$name => $value], null, 1);
		}

		/**
		 * Select a nesting entity from DB
		 *
		 * @return DB\Result|false : the selection result object or false on failure
		 */

		private function selectNesting(string $name, string $value) {

			# Process selection

			$selection = array_keys($this->definition->getParams());

			foreach ($selection as $key => $field) $selection[$key] = ('ent.' . $field);

			# Process query

			$query = ("SELECT " . implode(', ', $selection) . ", rel.ancestor as parent_id ") .

			         ("FROM " . static::$table . " ent ") .

			         ("LEFT JOIN " . static::$table_relations . " rel ON rel.descendant = ent.id AND rel.depth = 1 ") .

			         ("WHERE ent." . $name . " = '" . addslashes($value) . "' LIMIT 1");

			# ------------------------

			return DB::send($query);
		}

		/**
		 * Update the entity dataset with a selected data. Also updates every entity object having an identical id
		 *
		 * @return true : always true ;)
		 */

		protected function setData(array $data) : bool {

			$id = $this->definition->getParam('id')->cast($data['id']);

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

		/**
		 * Constructor
		 */

		public function __construct() {

			# Get definition

			$this->definition = Entitizer::getDefinition(static::$table);

			# Preset data

			$this->dataset = Entitizer::getDataset(static::$table);
		}

		/**
		 * Initialize the entity by a unique param (default: id)
		 *
		 * @return bool : true on success or false on failure
		 */

		public function init($value, string $name = 'id') : bool {

			if (0 !== $this->id) return false;

			# Get initiation index

			if (false === ($index = $this->definition->getIndex($name))) return false;

			if (($index->type !== 'PRIMARY') && ($index->type !== 'UNIQUE')) return false;

			# Process name & value

			$name = $index->name; $value = $this->definition->getParam($name)->cast($value);

			# Select entity from DB

			if (!static::$nesting) $this->selectBasic($name, $value); else $this->selectNesting($name, $value);

			# ------------------------

			return ((DB::getLast() && (DB::getLast()->rows === 1)) ? $this->setData(DB::getLast()->getRow()) : false);
		}

		/**
		 * Check whether another entity with a given unique param value exists.
		 * This method is useful to find out is it possible to change the entity's unique param value to the given one
		 *
		 * @return int|false : the number of entities found (0 or 1) or false on error
		 */

		public function check($value, string $name) {

			# Get initiation index

			if (false === ($index = $this->definition->getIndex($name))) return false;

			if ($index->type !== 'UNIQUE') return false;

			# Process name & value

			$name = $index->name; $value = $this->definition->getParam($name)->cast($value);

			# Select entity from DB

			$condition = ($name . " = '" . addslashes($value) . "' AND id != " . $this->id);

			DB::select(static::$table, 'id', $condition, null, 1);

			# ------------------------

			return ((DB::getLast() && DB::getLast()->status) ? DB::getLast()->rows : false);
		}

		/**
		 * Check if the entity has been successfully initialized
		 */

		public function isInited() : bool {

			return (0 !== $this->id);
		}

		/**
		 * Get the entity definition
		 */

		public function getDefinition() : Entitizer\Utils\Definition {

			return $this->definition;
		}

		/**
		 * Get a param value
		 *
		 * @return mixed|null : the value or null if the param does not exist
		 */

		public function get(string $name) {

			return $this->dataset->get($name);
		}

		/**
		 * Get the array of params and their values
		 */

		public function getData() : array {

			return $this->dataset->getData();
		}

		/**
		 * An alias for the get method
		 */

		public function __get(string $name) {

			return $this->dataset->__get($name);
		}

		/**
		 * Check if a param exists
		 */

		 public function __isset(string $name) : bool {

 			return $this->dataset->__isset($name);
 		}
	}
}
