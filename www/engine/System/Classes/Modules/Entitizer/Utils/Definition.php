<?php

namespace Modules\Entitizer\Utils {

	use DB;

	abstract class Definition {

		protected $params = null, $indexes = null, $foreigns = null;

		# Get list of statements

		private function getStatements() {

			$statements = [];

			foreach ([$this->params, $this->indexes, $this->foreigns] as $group) {

				foreach ($group->list() as $item) $statements[] = $item->statement();
			}

			# ------------------------

			return $statements;
		}

		# Create main table

		private function createMainTable() {

			$query = ("CREATE TABLE IF NOT EXISTS `" . static::$table . "` (") .

			         implode(", ", $this->getStatements()) .

			         (") ENGINE=InnoDB DEFAULT CHARSET=utf8");

			# ------------------------

			return (DB::send($query) && DB::getLast()->status);
		}

		# Create relations table

		private function createRelationsTable() {

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

		# Drop main table

		private function removeMainTable() {

			$query = ("DROP TABLE IF EXISTS `" . static::$table  . "`");

			return (DB::send($query) && DB::getLast()->status);
		}

		# Drop relations table

		private function removeRelationsTable() {

			$query = ("DROP TABLE IF EXISTS `" . static::$table_relations  . "`");

			return (DB::send($query) && DB::getLast()->status);
		}

		# Constructor

		public function __construct() {

			$this->params = new Definition\Group\Params($this, static::$auto_increment);

			$this->indexes = new Definition\Group\Indexes($this);

			$this->foreigns = new Definition\Group\Foreigns($this);

			# Define specific params

			$this->define();
		}

		# Return params

		public function params() {

			return $this->params->list();
		}

		# Return secure params

		public function paramsSecure() {

			return $this->params->secure();
		}

		# Return param by name

		public function param(string $name) {

			return $this->params->get($name);
		}

		# Return indexes

		public function indexes() {

			return $this->indexes->list();
		}

		# Return index by name

		public function index(string $name) {

			return $this->indexes->get($name);
		}

		# Return foreigns

		public function foreigns() {

			return $this->foreigns->list();
		}

		# Return foreign by name

		public function foreign(string $name) {

			return $this->foreigns->get($name);
		}

		# Create tables

		public function createTables() {

			return ($this->createMainTable() && (!static::$nesting || $this->createRelationsTable()));
		}

		# Remove tables

		public function removeTables() {

			return ((!static::$nesting || $this->removeRelationsTable()) && $this->removeMainTable());
		}
	}
}
