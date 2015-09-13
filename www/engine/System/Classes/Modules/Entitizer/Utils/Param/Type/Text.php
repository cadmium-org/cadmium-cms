<?php

namespace System\Modules\Entitizer\Utils\Param\Type {

	use System\Modules\Entitizer;

	class Text extends Entitizer\Utils\Param\General\String {

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
