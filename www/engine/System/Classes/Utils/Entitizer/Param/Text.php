<?php

namespace System\Utils\Entitizer\Param {

	class Text extends General\String {

        # Get field statement

        public function fieldStatement() {

            return ("`" . $this->name . "` text NOT NULL");
        }

        # Get key statement

        public function keyStatement() {

            return false;
        }
    }
}
