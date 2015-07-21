<?php

namespace System\Utils\Entity {

	use Number, String, Validate;

	class Params {

		private $params = false;

		# Constructor

		public function __construct() {

            $this->params['id'] = new Param\Id('id');
		}

		# Add relation param

        public function relation($name) {

			$this->params[$name] = new Param\Relation($name);
        }

		# Add boolean param

        public function boolean($name, $default = false, $index = false) {

			$this->params[$name] = new Param\Boolean($name, $default, $index);
        }

		# Add range param

        public function range($name, $default = false, $index = false) {

            $this->params[$name] = new Param\Range($name, $default, $index);
        }

		# Add varchar param

        public function varchar($name, $maxlength = null, $index = false) {

            $this->params[$name] = new Param\Varchar($name, $maxlength, $index);
        }

		# Add unique param

        public function unique($name, $maxlength = null) {

            $this->params[$name] = new Param\Unique($name, $maxlength);
        }

		# Add hash param

        public function hash($name) {

            $this->params[$name] = new Param\Hash($name);
        }

		# Add text param

        public function text($name) {

            $this->params[$name] = new Param\Text($name);
        }

		# Add time param

        public function time($name) {

            $this->params[$name] = new Param\Time($name);
        }

		# Get fieldset

		public function fieldset() {

			$fieldset = array();

			foreach ($this->params as $param) {

				if (false !== ($statement = $param->getFieldStatement())) $fieldset[] = $statement;
			}

			return $fieldset;
		}

		# Get keyset

		public function keyset() {

			$keyset = array();

			foreach ($this->params as $param) {

				if (false !== ($statement = $param->getKeyStatement())) $keyset[] = $statement;
			}

			return $keyset;
		}

		# Return array

        public function get() {

            return $this->params;
        }
    }
}

?>
