<?php

namespace System\Modules\Entitizer\Utils\Param\Type {

	use System\Modules\Entitizer;

	class Hash extends Entitizer\Utils\Param\General\String {

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
