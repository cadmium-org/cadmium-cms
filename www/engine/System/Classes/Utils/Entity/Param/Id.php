<?php

namespace System\Utils\Entity\Param {

    use System\Utils\Entity;

	class Id extends General\Number {

        # Get field statement

        public function getFieldStatement() {

            return ("`" . $this->name . "` int(10) unsigned NOT NULL AUTO_INCREMENT");
        }

        # Get key statement

        public function getKeyStatement() {

            return ("PRIMARY KEY (`" . $this->name . "`)");
        }
    }
}
