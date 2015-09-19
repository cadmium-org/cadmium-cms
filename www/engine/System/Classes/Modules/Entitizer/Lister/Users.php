<?php

namespace System\Modules\Entitizer\Lister {

	use System\Modules\Entitizer, Template;

	class Users extends Entitizer\Utils\Lister {

		use Entitizer\Common\User;

		# Lister configuration

		protected static $order = ['rank DESC', 'name ASC'];
	}
}
