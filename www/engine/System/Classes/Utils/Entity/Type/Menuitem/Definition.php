<?php

namespace System\Utils\Entity\Type\Menuitem {

	use System\Utils\Entity;

	class Definition extends Entity\Entity {

        protected $table = TABLE_MENU, $nesting = true;

        # Define params

        protected function define() {

            $this->params->relation         ('parent_id');
            $this->params->range            ('position', 0, true);
            $this->params->varchar          ('link');
            $this->params->varchar          ('text');
            $this->params->range            ('target');
        }
    }
}

?>
