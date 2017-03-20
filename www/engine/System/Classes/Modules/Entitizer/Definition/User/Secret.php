<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Definition\User {

	use Modules\Entitizer;

	class Secret extends Entitizer\Utils\Definition {

		use Entitizer\Common\User\Secret;

		/**
		 * Define the entity fields
		 */

		protected function define() {

			# Add params

			$this->params->addTextual       ('code',                true, 40, true, '');
			$this->params->addTextual       ('ip',                  true, 255, false, '');
			$this->params->addInteger       ('time',                false, 10, true, 0);

			# Add indexes

			$this->indexes->add             ('code',                'UNIQUE');
			$this->indexes->add             ('ip');
			$this->indexes->add             ('time');

			# Add foreign keys

			$this->foreigns->add            ('id',                  TABLE_USERS, 'id', 'CASCADE', 'RESTRICT');
		}
	}
}
