<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer {

	abstract class Listview extends Utils\Factory {

		protected static $error_message = 'The listview class for the given table does not exist';

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
