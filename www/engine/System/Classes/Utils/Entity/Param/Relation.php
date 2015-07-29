<?php

namespace System\Utils\Entity\Param {

    use System\Utils\Entity, Number, String;

	class Relation extends Entity\Param {

        private $entity = false;

        # Constructor

        public function __construct($name, $type) {

            $this->name = String::validate($name); $this->type = String::validate($type);
        }

        # Set value

        public function set($value) {

            return ($this->value = Number::unsigned($value));
        }

        # Get entity

        public function entity() {

            if (0 === $this->value) return true;

            $this->entity = Entity\Factory::create($this->type, $this->value);

            return ((false !== $this->entity->id) ? $this->entity : false);
        }

        # Get field statement

        public function getFieldStatement() {

            return ("`" . $this->name . "` int(10) unsigned NOT NULL DEFAULT '0'");
        }

        # Get key statement

        public function getKeyStatement() {

            return ("KEY `" . $this->name . "` (`" . $this->name . "`)");
        }
    }
}

?>
