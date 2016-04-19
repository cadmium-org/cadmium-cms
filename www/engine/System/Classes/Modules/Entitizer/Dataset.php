<?php

namespace Modules\Entitizer {

	abstract class Dataset extends Utils\Factory {

		protected static $error_message = 'Dataset class for given table does not exist';

		# Objects cache

		protected static $cache = [];

		# Datasets classes

		protected static $classes = [

			TABLE_PAGES             => 'Modules\Entitizer\Dataset\Page',
			TABLE_MENU              => 'Modules\Entitizer\Dataset\Menuitem',
			TABLE_VARIABLES         => 'Modules\Entitizer\Dataset\Variable',
			TABLE_WIDGETS           => 'Modules\Entitizer\Dataset\Widget',
			TABLE_USERS             => 'Modules\Entitizer\Dataset\User',
			TABLE_USERS_SECRETS     => 'Modules\Entitizer\Dataset\User\Secret',
			TABLE_USERS_SESSIONS    => 'Modules\Entitizer\Dataset\User\Session'
		];

		# Get dataset

		public static function get(string $table, array $data = []) {

			return (clone parent::get($table))->update($data);
		}
	}
}
