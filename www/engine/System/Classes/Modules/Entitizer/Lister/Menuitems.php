<?php

namespace System\Modules\Entitizer\Lister {

	use System\Modules\Entitizer, Template;

	class Menuitems extends Entitizer\Utils\Lister {

		use Entitizer\Common\Menuitem;

		# Lister configuration

		protected static $order = ['position ASC'];
	}
}
