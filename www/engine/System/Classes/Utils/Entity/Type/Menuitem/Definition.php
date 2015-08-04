<?php

namespace System\Utils\Entity\Type\Menuitem {

	use System\Utils\Entity;

	/**
	 * @property-read int $position
	 * @property-read string $link
	 * @property-read string $text
	 * @property-read int $target
	 */

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
