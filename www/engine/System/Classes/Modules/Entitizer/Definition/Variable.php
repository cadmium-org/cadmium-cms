<?php

namespace Modules\Entitizer\Definition {

	use Modules\Entitizer;

	class Variable extends Entitizer\Utils\Definition {

		use Entitizer\Common\Variable;

		# Define presets

		protected function define() {

			# Add params

			$this->params->textual      ('name',                true, 255, false, '');
			$this->params->textual      ('title',               true, 255, false, '');
			$this->params->textual      ('value',               true, 255, false, '');

			# Add indexes

			$this->indexes->add         ('name',                'UNIQUE');
			$this->indexes->add         ('title');
		}
	}
}
