<?php

namespace Modules\Entitizer\Utils {

	use DB;

	abstract class Definition {

		private $id = null, $params = [], $orderers = [];

		# Add param to set

		private function addParam(Param $param) {

			if (('' === $param->name()) || isset($this->params[$param->name()])) return;

			$this->params[$param->name()] = $param;
		}


		# Get list of params statements

		private function getStatements($method) {

			$statements = [$this->id->$method()];

			foreach ($this->params as $param) {

				if (false !== ($statement = $param->$method())) $statements[] = $statement;
			}

			# ------------------------

			return $statements;
		}

		# Add boolean param

		protected function addBoolean(string $name, bool $default = false, bool $index = false) {

			$this->addParam(new Param\Type\Boolean($name, $default, $index));
		}

		# Add integer param

		protected function addInteger(string $name, bool $short = false, int $maxlength = 0,

			int $default = 0, bool $index = false, bool $unique = false) {

			$this->addParam(new Param\Type\Integer($name, $short, $maxlength, $default, $index, $unique));
		}

		# Add textual param

		protected function addTextual(string $name, bool $text = false, int $maxlength = 0,

			bool $binary = false, bool $index = false, bool $unique = false) {

			$this->addParam(new Param\Type\Textual($name, $text, $maxlength, $binary, $index, $unique));
		}

		# Add orderer to set

		protected function addOrderer(string $name, bool $descending = false) {

			if (!isset($this->params[$name]) || isset($this->orderers[$name])) return;

			$this->orderers[$name] = $descending;
		}

		# Constructor

		public function __construct() {

			$this->id = new Param\Id('id', static::$auto_increment);

			# Define specific entity params

			$this->define();
		}

		# Create table

		public function createTable() {

			$set = array_merge($this->getStatements('fieldStatement'), $this->getStatements('keyStatement'));

			$query = ("CREATE TABLE IF NOT EXISTS `" . static::$table . "`") .

					 ("(" . implode(", ", $set) . ") ENGINE=InnoDB DEFAULT CHARSET=utf8");

			# ------------------------

			return (DB::send($query) && DB::last()->status);
		}

		# Return id param

		public function id() {

			return $this->id;
		}

		# Return params

		public function params() {

			return $this->params;
		}

		# Return orderers

		public function orderers() {

			return $this->orderers;
		}

		# Return param by name

		public function get(string $name) {

			return (isset($this->params[$name]) ? $this->params[$name] : false);
		}

		# Cast data to be suitable with current definition

		public function cast(array $data) {

			$params = [];

			foreach ($data as $name => $value) if (isset($this->params[$name])) {

				$params[$name] = $this->params[$name]->cast($value);
			}

			# ------------------------

			return $params;
		}
	}
}
