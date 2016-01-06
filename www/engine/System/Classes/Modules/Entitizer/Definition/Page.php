<?php

namespace Modules\Entitizer\Definition {

	use Modules\Entitizer;

	class Page extends Entitizer\Utils\Definition {

		use Entitizer\Common\Page;

		# Define presets

		protected function define() {

			# Add params

			$this->addInteger       ('parent_id',       false, 10, 0, true, false);
			$this->addInteger       ('visibility',      true, 1, VISIBILITY_DRAFT, true, false);
			$this->addInteger       ('access',          true, 1, ACCESS_PUBLIC, true, false);
			$this->addTextual       ('hash',            true, 40, true, true, true);
			$this->addTextual       ('name',            true, 255, false, true, false);
			$this->addTextual       ('title',           true, 255, false, true, false);
			$this->addTextual       ('contents',        false, 0, false, false, false);
			$this->addTextual       ('description',     false, 0, false, false, false);
			$this->addTextual       ('keywords',        false, 0, false, false, false);
			$this->addBoolean       ('robots_index',    true, false);
			$this->addBoolean       ('robots_follow',   true, false);
			$this->addInteger       ('time_created',    false, 10, 0, true, false);
			$this->addInteger       ('time_modified',   false, 10, 0, true, false);

			# Add orderers

			$this->addOrderer       ('title');
		}
	}
}
