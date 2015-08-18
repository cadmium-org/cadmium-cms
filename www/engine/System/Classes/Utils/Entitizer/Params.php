<?php

namespace System\Utils\Entitizer {

	class Params {

		private $id = null, $params = array();

		# Add param to set

		private function addParam($param) {

			if (('' === $param->name()) || isset($this->params[$param->name()])) return false;

			$this->params[$param->name()] = $param;
		}

		# Get list of params statements

		private function getStatements($method) {

			$statements = array(call_user_method($method, $this->id));

			foreach ($this->params as $param) {

				if (false !== ($statement = call_user_method($method, $param))) $statements[] = $statement;
			}

			return $statements;
		}

		# Constructor

		public function __construct($auto_increment = true) {

            $this->id = new Param\Id('id', $auto_increment);
		}

		# Add relation param

        public function relation($name, $type) {

			$this->addParam(new Param\Relation($name, $type));
        }

		# Add boolean param

        public function boolean($name, $default = false, $index = false) {

			$this->addParam(new Param\Boolean($name, $default, $index));
        }

		# Add range param

        public function range($name, $default = 0, $index = false) {

            $this->addParam(new Param\Range($name, $default, $index));
        }

		# Add varchar param

        public function varchar($name, $maxlength = null, $index = false) {

            $this->addParam(new Param\Varchar($name, $maxlength, $index));
        }

		# Add unique param

        public function unique($name, $maxlength = null) {

            $this->addParam(new Param\Unique($name, $maxlength));
        }

		# Add hash param

        public function hash($name) {

            $this->addParam(new Param\Hash($name));
        }

		# Add text param

        public function text($name) {

            $this->addParam(new Param\Text($name));
        }

		# Add time param

        public function time($name) {

            $this->addParam(new Param\Time($name));
        }

		# Get fieldset

		public function fieldset() {

			return $this->getStatements('fieldStatement');
		}

		# Get keyset

		public function keyset() {

			return $this->getStatements('keyStatement');
		}

		# Return id

		public function id() {

			return $this->id;
		}

		# Return array

        public function get($name = null) {

            if (null === $name) return $this->params;

			$name = strval($name);

			return (isset($this->params[$name]) ? $this->params[$name] : false);
        }
    }
}
