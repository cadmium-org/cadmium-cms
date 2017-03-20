<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Definition {

	use Modules\Entitizer;

	class Menuitem extends Entitizer\Utils\Definition {

		use Entitizer\Common\Menuitem;

		/**
		 * Define the entity fields
		 */

		protected function define() {

			# Add params

			$this->params->addBoolean       ('active',              false);
			$this->params->addInteger       ('position',            true, 2, true, 0);
			$this->params->addTextual       ('slug',                true, 255, false, '');
			$this->params->addTextual       ('text',                true, 255, false, '');
			$this->params->addInteger       ('target',              true, 1, true, TARGET_SELF);

			# Add indexes

			$this->indexes->add             ('active');
			$this->indexes->add             ('position');
		}
	}
}
