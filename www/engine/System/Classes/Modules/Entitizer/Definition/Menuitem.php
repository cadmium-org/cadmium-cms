<?php

namespace Modules\Entitizer\Definition {

	use Modules\Entitizer;

	class Menuitem extends Entitizer\Utils\Definition {

		use Entitizer\Common\Menuitem;

		# Define presets

		protected function define() {

			# Add params

			$this->params->boolean      ('active',              false);
			$this->params->integer      ('position',            true, 2, true, 0);
			$this->params->textual      ('slug',                true, 255, false, '');
			$this->params->textual      ('text',                true, 255, false, '');
			$this->params->integer      ('target',              true, 1, true, TARGET_SELF);

			# Add indexes

			$this->indexes->add         ('active');
			$this->indexes->add         ('position');
		}
	}
}
