<?php

namespace System\Utils\Entitizer\Type\Menuitem {

	use System\Utils\Entitizer;

	abstract class Definition extends Entitizer\Utils\Type\Nesting {

		protected $type = ENTITY_TYPE_MENUITEM, $table = TABLE_MENU;

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
