<?php

namespace Modules\Entitizer {

	abstract class Treeview extends Utils\Factory {

		protected static $error_message = 'Treeview class for given table does not exist';

		# Objects cache

		protected static $cache = [];

		# Treeview classes

		protected static $classes = [

			TABLE_PAGES             => 'Modules\Entitizer\Treeview\Pages',
			TABLE_MENU              => 'Modules\Entitizer\Treeview\Menuitems',
			TABLE_VARIABLES         => 'Modules\Entitizer\Treeview\Variables',
			TABLE_WIDGETS           => 'Modules\Entitizer\Treeview\Widgets',
			TABLE_USERS             => 'Modules\Entitizer\Treeview\Users'
		];
	}
}
