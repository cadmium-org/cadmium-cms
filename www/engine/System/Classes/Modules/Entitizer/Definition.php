<?php

namespace Modules\Entitizer {

	abstract class Definition extends Utils\Factory {

		protected static $error_message = 'Definition class for given table does not exist';

		# Objects cache

		protected static $cache = [];

		# Definitions classes

		protected static $classes = [

			TABLE_PAGES             => 'Modules\Entitizer\Definition\Page',
			TABLE_MENU              => 'Modules\Entitizer\Definition\Menuitem',
			TABLE_VARIABLES         => 'Modules\Entitizer\Definition\Variable',
			TABLE_WIDGETS           => 'Modules\Entitizer\Definition\Widget',
			TABLE_USERS             => 'Modules\Entitizer\Definition\User',
			TABLE_USERS_SECRETS     => 'Modules\Entitizer\Definition\User\Secret',
			TABLE_USERS_SESSIONS    => 'Modules\Entitizer\Definition\User\Session'
		];
	}
}
