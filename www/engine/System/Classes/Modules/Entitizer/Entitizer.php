<?php

namespace Modules {

	use Exception;

	abstract class Entitizer extends Entitizer\Utils\Cache {

		private static $error_message = 'Entity class for given table does not exist';

		# Entities classes

		protected static $classes = [

			TABLE_PAGES             => 'Modules\Entitizer\Entity\Page',
			TABLE_MENU              => 'Modules\Entitizer\Entity\Menuitem',
			TABLE_VARIABLES         => 'Modules\Entitizer\Entity\Variable',
			TABLE_WIDGETS           => 'Modules\Entitizer\Entity\Widget',
			TABLE_USERS             => 'Modules\Entitizer\Entity\User',
			TABLE_USERS_SECRETS     => 'Modules\Entitizer\Entity\User\Secret',
			TABLE_USERS_SESSIONS    => 'Modules\Entitizer\Entity\User\Session'
		];

		# Get entity

		public static function get(string $table, int $id = 0) {

			if (!isset(self::$classes[$table])) throw new Exception\General(self::$error_message);

			if (isset(self::$cache[$table][$id])) return self::$cache[$table][$id];

			$entity = new self::$classes[$table]; $entity->init($id);

			# ------------------------

			return $entity;
		}

		# Get dataset

		public static function dataset(string $table, array $data = []) {

			return Entitizer\Dataset::get($table, $data);
		}

		# Get definition

		public static function definition(string $table) {

			return Entitizer\Definition::get($table);
		}

		# Get listview

		public static function listview(string $table) {

			return Entitizer\Listview::get($table);
		}

		# Get treeview

		public static function treeview(string $table) {

			return Entitizer\Treeview::get($table);
		}
	}
}
