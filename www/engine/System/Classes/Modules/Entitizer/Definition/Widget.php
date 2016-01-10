<?php

namespace Modules\Entitizer\Definition {

	use Modules\Entitizer;

	class Widget extends Entitizer\Utils\Definition {

		use Entitizer\Common\Widget;

		# Define presets

		protected function define() {

			# Add params

			$this->addTextual       ('name',            true, 255, false, true, true);
			$this->addTextual       ('title',           true, 255, false, true, false);
			$this->addBoolean       ('display',         true, true);
			$this->addTextual       ('contents',        false, 0, false, false, false);

			# Add orderers

			$this->addOrderer       ('title');
		}
	}
}
