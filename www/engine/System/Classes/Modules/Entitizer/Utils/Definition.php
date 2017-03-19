<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Utils {

	use DB;

	abstract class Definition {

		protected $params = null, $indexes = null, $foreigns = null;

		/**
		 * Get the list of statements
		 */

		private function getStatements() : array {

			$statements = [];

			foreach ([$this->params, $this->indexes, $this->foreigns] as $group) {

				foreach ($group->getList() as $item) $statements[] = $item->getStatement();
			}

			# ------------------------

			return $statements;
		}

		/**
		 * Create the main table
		 *
		 * @return bool : true on success or false on failure
		 */

		private function createMainTable() : bool {

			$query = ("CREATE TABLE IF NOT EXISTS `" . static::$table . "` (") .

			         implode(", ", $this->getStatements()) .

			         (") ENGINE=InnoDB DEFAULT CHARSET=utf8");

			# ------------------------

			return (DB::send($query) && DB::getLast()->status);
		}

		/**
		 * Create the relations table
		 *
		 * @return bool : true on success or false on failure
		 */

		private function createRelationsTable() : bool {

			$query = ("CREATE TABLE IF NOT EXISTS `" . static::$table_relations . "` (") .

					 ("`ancestor` int(10) UNSIGNED NOT NULL, `descendant` int(10) UNSIGNED NOT NULL, ") .

					 ("`depth` int(10) UNSIGNED NOT NULL, ") .

					 ("PRIMARY KEY (`ancestor`, `descendant`), KEY (`ancestor`), KEY (`descendant`), KEY (`depth`), ") .

					 ("FOREIGN KEY (`ancestor`) REFERENCES `" . static::$table . "` (`id`) ON DELETE CASCADE, ") .

					 ("FOREIGN KEY (`descendant`) REFERENCES `" . static::$table . "` (`id`) ON DELETE CASCADE ") .

					 (") ENGINE=InnoDB DEFAULT CHARSET=utf8");

			# ------------------------

		 	return (DB::send($query) && DB::getLast()->status);
		}

		/**
		 * Drop the main table
		 *
		 * @return bool : true on success or false on failure
		 */

		private function removeMainTable() : bool {

			$query = ("DROP TABLE IF EXISTS `" . static::$table  . "`");

			return (DB::send($query) && DB::getLast()->status);
		}

		/**
		 * Drop the relations table
		 *
		 * @return bool : true on success or false on failure
		 */

		private function removeRelationsTable() : bool {

			$query = ("DROP TABLE IF EXISTS `" . static::$table_relations  . "`");

			return (DB::send($query) && DB::getLast()->status);
		}

		/**
		 * Constructor
		 */

		public function __construct() {

			$this->params = new Definition\Group\Params($this, static::$auto_increment);

			$this->indexes = new Definition\Group\Indexes($this);

			$this->foreigns = new Definition\Group\Foreigns($this);

			# Define specific params

			$this->define();
		}

		/**
		 * Get a param
		 *
		 * @return Entitizer\Utils\Definition\Item\Param|false : the param object or false if the param does not exist
		 */

		public function getParam(string $name) {

			return $this->params->get($name);
		}

		/**
		 * Get the params list
		 */

		public function getParams() : array {

			return $this->params->getList();
		}

		/**
		 * Get the secure params list (includes every param except of long textuals)
		 */

		public function getParamsSecure() : array {

			return $this->params->getSecure();
		}

		/**
		 * Get an index
		 *
		 * @return Entitizer\Utils\Definition\Item\Index|false : the index object or false if the index does not exist
		 */

		public function getIndex(string $name) {

			return $this->indexes->get($name);
		}

		/**
		 * Get the indexes list
		 */

		public function getIndexes() : array {

			return $this->indexes->getList();
		}

		/**
		 * Get a foreign
		 *
		 * @return Entitizer\Utils\Definition\Item\Foreign|false : the foreign object or false if the foreign does not exist
		 */

		public function getForeign(string $name) {

			return $this->foreigns->get($name);
		}

		/**
		 * Get the foreigns list
		 */

		public function getForeigns() : array {

			return $this->foreigns->getList();
		}

		/**
		 * Create entity table(s)
		 *
		 * @return bool : true on success or false on failure
		 */

		public function createTables() : bool {

			return ($this->createMainTable() && (!static::$nesting || $this->createRelationsTable()));
		}

		/**
		 * Remove entity table(s)
		 *
		 * @return bool : true on success or false on failure
		 */

		public function removeTables() : bool {

			return ((!static::$nesting || $this->removeRelationsTable()) && $this->removeMainTable());
		}
	}
}
