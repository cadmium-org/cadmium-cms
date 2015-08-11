<?php

namespace System\Utils\Entity\Param {

    use System\Utils\Entity;

	class Text extends General\String {

        # Get field statement

        public function getFieldStatement() {

            return ("`" . $this->name . "` text NOT NULL");
        }

        # Get key statement

        public function getKeyStatement() {

            return false;
        }
    }
}
