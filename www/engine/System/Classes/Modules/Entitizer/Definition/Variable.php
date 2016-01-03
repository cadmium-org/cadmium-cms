<?php

namespace System\Modules\Entitizer\Definition {

	use System\Modules\Entitizer;

	class Variable extends Entitizer\Utils\Definition {

		use Entitizer\Common\Variable;

		# Define presets

		protected function define() {

			# Add params

			$this->addTextual       ('name',            true, 255, false, true, true);
			$this->addTextual       ('title',           true, 255, false, true, false);
			$this->addTextual       ('value',           true, 255, false, false, false);

			# Add orderers

			$this->addOrderer       ('title');
		}
	}
}
