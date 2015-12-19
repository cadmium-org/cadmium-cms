<?php

namespace System\Modules\Entitizer\Definition {

	use System\Modules\Entitizer;

	class Page extends Entitizer\Utils\Definition {

		use Entitizer\Common\Page;

		# Define presets

		protected function define() {

			# Add params

			$this->numeric      ('parent_id',       false, 10, 0, true, false);
			$this->numeric      ('visibility',      true, 1, VISIBILITY_DRAFT, true, false);
			$this->numeric      ('access',          true, 1, ACCESS_PUBLIC, true, false);
			$this->textual      ('hash',            true, 40, true, true, true);
			$this->textual      ('name',            true, 255, false, true, false);
			$this->textual      ('title',           true, 255, false, true, false);
			$this->textual      ('contents',        false, 0, false, false, false);
			$this->textual      ('description',     false, 0, false, false, false);
			$this->textual      ('keywords',        false, 0, false, false, false);
			$this->numeric      ('robots_index',    true, 1, 1, false, false);
			$this->numeric      ('robots_follow',   true, 1, 1, false, false);
			$this->numeric      ('time_created',    false, 10, 0, true, false);
			$this->numeric      ('time_modified',   false, 10, 0, true, false);
		}
	}
}
