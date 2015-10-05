<?php

namespace System\Modules\Entitizer\Definition {

	use System\Modules\Entitizer;

	class Page extends Entitizer\Utils\Definition {

		use Entitizer\Common\Page;

		# Define presets

		protected function define() {

			# Add params

			$this->range        ('visibility', VISIBILITY_DRAFT, true);
			$this->range        ('access', ACCESS_PUBLIC, true);
			$this->unique       ('hash');
			$this->varchar      ('name', null, true);
			$this->varchar      ('title', null, true);
			$this->text         ('contents');
			$this->text         ('description');
			$this->text         ('keywords');
			$this->boolean      ('robots_index', true);
			$this->boolean      ('robots_follow', true);
			$this->time         ('time_created');
			$this->time         ('time_modified');
		}
	}
}
