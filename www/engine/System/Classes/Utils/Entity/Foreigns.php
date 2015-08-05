<?php

namespace System\Utils\Entity {

    class Foreigns {

        private $foreigns = array();

        public function add($type, $field) {

            if ('' === ($type = strval($type))) return false;

			if ('' === ($field = strval($field))) return false;

			$class_name = ('System\\Utils\\Entity\\Type\\' . $type . '\\Definition');

			$table = @constant($class_name . '::TABLE');

			$this->foreigns[$table] = $field;

			# ------------------------

			return true;
		}

        public function get() {

            return $this->foreigns;
        }
    }
}
