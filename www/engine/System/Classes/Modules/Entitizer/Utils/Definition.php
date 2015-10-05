<?php

namespace System\Modules\Entitizer\Utils {

	use DB;

	abstract class Definition {

		private $id = null, $params = [];

		# Add param to set

		private function addParam($param) {

			if (('' === $param->name()) || isset($this->params[$param->name()])) return false;

			$this->params[$param->name()] = $param;
		}

		# Get list of params statements

		private function getStatements($method) {

			$statements = [call_user_func([$this->id, $method])];

			foreach ($this->params as $param) {

				if (false !== ($statement = call_user_func([$param, $method]))) $statements[] = $statement;
			}

			# ------------------------

			return $statements;
		}

		# Add relation param

		protected function relation($name) {

			$this->addParam(new Param\Type\Relation($name));
		}

		# Add boolean param

		protected function boolean($name, $default = false, $index = false) {

			$this->addParam(new Param\Type\Boolean($name, $default, $index));
		}

		# Add range param

		protected function range($name, $default = 0, $index = false) {

			$this->addParam(new Param\Type\Range($name, $default, $index));
		}

		# Add varchar param

		protected function varchar($name, $maxlength = null, $index = false) {

			$this->addParam(new Param\Type\Varchar($name, $maxlength, $index));
		}

		# Add unique param

		protected function unique($name, $maxlength = null) {

			$this->addParam(new Param\Type\Unique($name, $maxlength));
		}

		# Add hash param

		protected function hash($name) {

			$this->addParam(new Param\Type\Hash($name));
		}

		# Add text param

		protected function text($name) {

			$this->addParam(new Param\Type\Text($name));
		}

		# Add time param

		protected function time($name) {

			$this->addParam(new Param\Type\Time($name));
		}

		# Constructor

		public function __construct() {

			$this->id = new Param\Type\Id('id', static::$auto_increment);

			if (static::$nesting) $this->relation('parent_id');

			# ------------------------

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

		# Return param by name

		public function get($name) {

			$name = strval($name);

			return (isset($this->params[$name]) ? $this->params[$name] : false);
		}

		# Definer interface

		abstract protected function define();
	}
}
