<?php

namespace Modules\Entitizer\Definition {

	use Modules\Entitizer;

	class Widget extends Entitizer\Utils\Definition {

		use Entitizer\Common\Widget;

		# Define presets

		protected function define() {

			# Add params

			$this->params->boolean      ('active',              false);
			$this->params->textual      ('name',                true, 255, false, '');
			$this->params->textual      ('title',               true, 255, false, '');
			$this->params->textual      ('contents',            false, 0, false, '');

			# Add indexes

			$this->indexes->add         ('active');
			$this->indexes->add         ('name',                'UNIQUE');
			$this->indexes->add         ('title');
		}
	}
}
