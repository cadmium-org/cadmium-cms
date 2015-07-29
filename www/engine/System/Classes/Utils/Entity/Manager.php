<?php

namespace System\Utils\Entity {

    use Number, String;

    abstract class Manager {

        protected $entity = false;

        # Return entity data

        public function __get($name) {

            if (false === $this->entity) return false;

            return $this->entity->$name;
        }
    }
}

?>
