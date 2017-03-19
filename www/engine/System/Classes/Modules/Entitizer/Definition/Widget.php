<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Definition {

	use Modules\Entitizer;

	class Widget extends Entitizer\Utils\Definition {

		use Entitizer\Common\Widget;

		/**
		 * Define the entity fields
		 */

		protected function define() {

			# Add params

			$this->params->addBoolean       ('active',              false);
			$this->params->addTextual       ('name',                true, 255, false, '');
			$this->params->addTextual       ('title',               true, 255, false, '');
			$this->params->addTextual       ('contents',            false, 0, false, '');

			# Add indexes

			$this->indexes->add             ('active');
			$this->indexes->add             ('name',                'UNIQUE');
			$this->indexes->add             ('title');
		}
	}
}
