<?php

namespace System\Utils\Entitizer\Param {

	class Hash extends General\String {

        # Get field statement

        public function fieldStatement() {

            return ("`" . $this->name . "` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL");
        }

        # Get key statement

        public function keyStatement() {

            return ("UNIQUE KEY `" . $this->name . "` (`" . $this->name . "`)");
        }
    }
}
