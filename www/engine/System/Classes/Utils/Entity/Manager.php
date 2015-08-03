<?php

namespace System\Utils\Entity {

    abstract class Manager {

        protected $entity = null;

        # Return entity data

        public function __get($name) {

            if (null === $this->entity) return false;

            return $this->entity->$name;
        }
    }
}
