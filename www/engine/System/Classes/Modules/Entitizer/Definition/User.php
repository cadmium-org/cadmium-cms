<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Definition {

	use Modules\Entitizer;

	class User extends Entitizer\Utils\Definition {

		use Entitizer\Common\User;

		/**
		 * Define the entity fields
		 */

		protected function define() {

			# Add params

			$this->params->addInteger       ('rank',                true, 1, true, RANK_GUEST);
			$this->params->addTextual       ('name',                true, 16, false, '');
			$this->params->addTextual       ('email',               true, 128, false, '');
			$this->params->addTextual       ('auth_key',            true, 40, true, '');
			$this->params->addTextual       ('password',            true, 40, true, '');
			$this->params->addTextual       ('first_name',          true, 255, false, '');
			$this->params->addTextual       ('last_name',           true, 255, false, '');
			$this->params->addInteger       ('sex',                 true, 1, true, SEX_NOT_SELECTED);
			$this->params->addTextual       ('city',                true, 255, false, '');
			$this->params->addTextual       ('country',             true, 2, false, '');
			$this->params->addTextual       ('timezone',            true, 40, false, '');
			$this->params->addInteger       ('time_registered',     false, 10, true, 0);
			$this->params->addInteger       ('time_logged',         false, 10, true, 0);

			# Add indexes

			$this->indexes->add             ('rank');
			$this->indexes->add             ('name',                'UNIQUE');
			$this->indexes->add             ('email',               'UNIQUE');
			$this->indexes->add             ('time_registered');
			$this->indexes->add             ('time_logged');
		}
	}
}
