<?php

namespace System\Modules\Entitizer\Definition {

	use System\Modules\Entitizer;

	class Menuitem extends Entitizer\Utils\Definition {

		use Entitizer\Common\Menuitem;

		# Define presets

		protected function define() {

			# Add params

			$this->numeric      ('parent_id',       false, 10, 0, true, false);
			$this->numeric      ('position',        true, 2, 0, true, false);
			$this->textual      ('link',            true, 255, false, false, false);
			$this->textual      ('text',            true, 255, false, false, false);
			$this->numeric      ('target',          true, 1, TARGET_SELF, false, false);
		}
	}
}
