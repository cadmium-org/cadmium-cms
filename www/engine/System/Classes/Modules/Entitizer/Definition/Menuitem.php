<?php

namespace Modules\Entitizer\Definition {

	use Modules\Entitizer;

	class Menuitem extends Entitizer\Utils\Definition {

		use Entitizer\Common\Menuitem;

		# Define presets

		protected function define() {

			# Add params

			$this->addInteger       ('parent_id',       false, 10, 0, true, false);
			$this->addInteger       ('position',        true, 2, 0, true, false);
			$this->addTextual       ('slug',            true, 255, false, false, false);
			$this->addTextual       ('text',            true, 255, false, false, false);
			$this->addInteger       ('target',          true, 1, TARGET_SELF, false, false);

			# Add orderers

			$this->addOrderer       ('position');
		}
	}
}
