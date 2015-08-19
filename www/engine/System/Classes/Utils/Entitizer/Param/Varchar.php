<?php

namespace System\Utils\Entitizer\Param {

    use Number;

	class Varchar extends General\String {

        protected $maxlength = 0, $index = false;

        # Constructor

        public function __construct($name, $maxlength = null, $index = false) {

            parent::__construct($name);

            $this->maxlength = (($maxlength !== null) ? Number::format($maxlength, 0, 255) : 255);

            $this->index = boolval($index);
        }

        # Get field statement

        public function fieldStatement() {

            return ("`" . $this->name . "` varchar(" . $this->maxlength . ") NOT NULL");
        }

        # Get key statement

        public function keyStatement() {

            return ($this->index ? ("KEY `" . $this->name . "` (`" . $this->name . "`)") : false);
        }
    }
}