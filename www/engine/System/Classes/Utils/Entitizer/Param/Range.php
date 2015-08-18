<?php

namespace System\Utils\Entitizer\Param {

    use Number;

	class Range extends General\Number {

        private $default = 0, $index = false;

        # Constructor

        public function __construct($name, $default = 0, $index = false) {

            parent::__construct($name);

            $this->default = Number::format($default, 0, 99); $this->index = boolval($index);
        }

        # Get field statement

        public function fieldStatement() {

            return ("`" . $this->name . "` tinyint(2) unsigned NOT NULL DEFAULT '" . $this->default . "'");
        }

        # Get key statement

        public function keyStatement() {

            return ($this->index ? ("KEY `" . $this->name . "` (`" . $this->name . "`)") : false);
        }
    }
}
