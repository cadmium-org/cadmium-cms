<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Definition {

	use Modules\Entitizer;

	class Variable extends Entitizer\Utils\Definition {

		use Entitizer\Common\Variable;

		/**
		 * Define the entity fields
		 */

		protected function define() {

			# Add params

			$this->params->addTextual       ('name',                true, 255, false, '');
			$this->params->addTextual       ('title',               true, 255, false, '');
			$this->params->addTextual       ('value',               true, 255, false, '');

			# Add indexes

			$this->indexes->add             ('name',                'UNIQUE');
			$this->indexes->add             ('title');
		}
	}
}
