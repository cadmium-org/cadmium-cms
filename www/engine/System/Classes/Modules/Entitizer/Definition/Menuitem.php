<?php

namespace System\Modules\Entitizer\Definition {

	use System\Modules\Entitizer;

	class Menuitem extends Entitizer\Utils\Definition {

		use Entitizer\Common\Menuitem;

        # Define presets

        protected function define() {

			# Add params

            $this->range        ('position', 0, true);
            $this->varchar      ('link');
            $this->varchar      ('text');
            $this->range        ('target');
        }
    }
}
