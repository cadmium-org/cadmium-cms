<?php

namespace System\Utils\Entity\Type\Menuitem {

	use System\Utils\Entity;

	class Definition extends Entity\Entity {

        const TYPE = 'Menuitem', TABLE = TABLE_MENU, NESTING = true;

        # Define presets

        protected function define() {

			# Add params

            $this->params->range            ('position', 0, true);
            $this->params->varchar          ('link');
            $this->params->varchar          ('text');
            $this->params->range            ('target');
        }
    }
}

?>
