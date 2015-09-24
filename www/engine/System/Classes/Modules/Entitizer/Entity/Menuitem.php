<?php

namespace System\Modules\Entitizer\Entity {

	use System\Modules\Entitizer;

	/**
	 * @property-read int $id
	 * @property-read int $position
	 * @property-read string $link
	 * @property-read string $text
	 * @property-read int $target
	 * @property-read array $path
	 */

	class Menuitem extends Entitizer\Utils\Entity {

		use Entitizer\Common\Menuitem;

		# Implement entity

		protected function implement() {}
	}
}
