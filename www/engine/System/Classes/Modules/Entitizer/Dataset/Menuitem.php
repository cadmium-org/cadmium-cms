<?php

namespace Modules\Entitizer\Dataset {

	use Modules\Entitizer, Utils\Validate;

	class Menuitem extends Entitizer\Utils\Dataset {

		use Entitizer\Common\Menuitem;

		# Init dataset

		protected function init() {

			$this->addHandler('link', function (array $data) {

				if ('' === $data['slug']) return '';

				if (false !== Validate::url($data['slug'])) return $data['slug'];

				return (INSTALL_PATH . '/' . $data['slug']);
			});
		}
	}
}
