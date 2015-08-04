<?php

namespace System\Utils\Entity {

	class Params {

		private $id = null, $params = array();

		# Add param to set

		private function add($param) {

			if (('' === $param->name()) || isset($this->params[$param->name()])) return false;

			$this->params[$param->name()] = $param;
		}

		# Constructor

		public function __construct() {

            $this->id = new Param\Id('id');
		}

		# Add relation param

        public function relation($name, $type) {

			$this->add(new Param\Relation($name, $type));
        }

		# Add boolean param

        public function boolean($name, $default = 0, $index = false) {

			$this->add(new Param\Boolean($name, $default, $index));
        }

		# Add range param

        public function range($name, $default = 0, $index = false) {

            $this->add(new Param\Range($name, $default, $index));
        }

		# Add varchar param

        public function varchar($name, $maxlength = null, $index = false) {

            $this->add(new Param\Varchar($name, $maxlength, $index));
        }

		# Add unique param

        public function unique($name, $maxlength = null) {

            $this->add(new Param\Unique($name, $maxlength));
        }

		# Add hash param

        public function hash($name) {

            $this->add(new Param\Hash($name));
        }

		# Add text param

        public function text($name) {

            $this->add(new Param\Text($name));
        }

		# Add time param

        public function time($name) {

            $this->add(new Param\Time($name));
        }

		# Get fieldset

		public function fieldset() {

			$fieldset = array($this->id->getFieldStatement());

			foreach ($this->params as $param) {

				if (false !== ($statement = $param->getFieldStatement())) $fieldset[] = $statement;
			}

			return $fieldset;
		}

		# Get keyset

		public function keyset() {

			$keyset = array($this->id->getKeyStatement());

			foreach ($this->params as $param) {

				if (false !== ($statement = $param->getKeyStatement())) $keyset[] = $statement;
			}

			return $keyset;
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
