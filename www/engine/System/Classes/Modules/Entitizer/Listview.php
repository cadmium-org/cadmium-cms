<?php

namespace Modules\Entitizer {

	abstract class Listview extends Utils\Factory {

		protected static $error_message = 'Listview class for given table does not exist';

		# Objects cache

		protected static $cache = [];

		# Listview classes

		protected static $classes = [

			TABLE_PAGES             => 'Modules\Entitizer\Listview\Pages',
			TABLE_MENU              => 'Modules\Entitizer\Listview\Menuitems',
			TABLE_VARIABLES         => 'Modules\Entitizer\Listview\Variables',
			TABLE_WIDGETS           => 'Modules\Entitizer\Listview\Widgets',
			TABLE_USERS             => 'Modules\Entitizer\Listview\Users'
		];
	}
}
