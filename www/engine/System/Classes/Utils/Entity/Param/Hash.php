<?php

namespace System\Utils\Entity\Param {

    use System\Utils\Entity;

	class Hash extends General\String {

        # Get field statement

        public function getFieldStatement() {

            return ("`" . $this->name . "` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL");
        }

        # Get key statement

        public function getKeyStatement() {

            return ("UNIQUE KEY `" . $this->name . "` (`" . $this->name . "`)");
        }
    }
}
