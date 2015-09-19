<?php

namespace System\Modules\Entitizer\Lister {

	use System\Modules\Entitizer, Template;

	class Pages extends Entitizer\Utils\Lister {

		use Entitizer\Common\Page;

		# Lister configuration

		protected static $order = ['title ASC'];
	}
}
