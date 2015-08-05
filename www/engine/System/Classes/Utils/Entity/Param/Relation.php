<?php

namespace System\Utils\Entity\Param {

    use System\Utils\Entity;

	class Relation extends Entity\Utils\Param {

        private $type = '';

        # Constructor

        public function __construct($name, $type) {

            $this->name = strval($name); $this->value = 0; $this->type = strval($type);
        }

        # Set value

        public function set($value) {

            return ($this->value = intabs($value));
        }

        # Get entity

        public function entity() {

            if (0 === $this->value) return true;

            $entity = Entity\Factory::create($this->type, $this->value);

            if ((false === $entity) || (0 === $entity->id)) return false;

            # ------------------------

            return $entity;
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
