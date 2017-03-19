<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Definition {

	use Modules\Entitizer;

	class Page extends Entitizer\Utils\Definition {

		use Entitizer\Common\Page;

		/**
		 * Define the entity fields
		 */

		protected function define() {

			# Add params

			$this->params->addInteger       ('visibility',          true, 1, true, VISIBILITY_DRAFT);
			$this->params->addInteger       ('access',              true, 1, true, ACCESS_PUBLIC);
			$this->params->addBoolean       ('locked',              true);
			$this->params->addTextual       ('slug',                true, 255, false, '');
			$this->params->addTextual       ('name',                true, 255, false, '');
			$this->params->addTextual       ('title',               true, 255, false, '');
			$this->params->addTextual       ('contents',            false, 0, false, '');
			$this->params->addTextual       ('description',         false, 0, false, '');
			$this->params->addTextual       ('keywords',            false, 0, false, '');
			$this->params->addBoolean       ('robots_index',        false);
			$this->params->addBoolean       ('robots_follow',       false);
			$this->params->addInteger       ('time_created',        false, 10, true, 0);
			$this->params->addInteger       ('time_modified',       false, 10, true, 0);

			# Add indexes

			$this->indexes->add             ('visibility');
			$this->indexes->add             ('access');
			$this->indexes->add             ('slug');
			$this->indexes->add             ('name');
			$this->indexes->add             ('title');
			$this->indexes->add             ('time_created');
			$this->indexes->add             ('time_modified');
		}
	}
}
