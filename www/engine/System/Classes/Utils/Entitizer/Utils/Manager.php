<?php

namespace System\Utils\Entitizer\Utils {

    abstract class Manager {

        protected $entity = null;

        # Return entity data

        public function __get($name) {

            if (null === $this->entity) return null;

            return $this->entity->$name;
        }
    }
}