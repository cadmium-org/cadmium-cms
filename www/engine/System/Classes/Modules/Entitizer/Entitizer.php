<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules {

	use Exception;

	abstract class Entitizer extends Entitizer\Utils\Cache {

		private static $error_message = 'The entity class for the given table does not exist';

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

		/**
		 * Get an entity object by a given type (a table name) and an id. If the entity has not been already loaded,
		 * it will be selected from database, otherwise the cached object will be returned.
		 * If the id is not given or equals 0, an empty entity will be returned.
		 * If the table name is invalid, an exception will be thrown
		 */

		public static function get(string $table, int $id = 0) : Entitizer\Utils\Entity {

			if (!isset(self::$classes[$table])) throw new Exception\General(self::$error_message);

			if (isset(self::$cache[$table][$id])) return self::$cache[$table][$id];

			$entity = new self::$classes[$table]; $entity->init($id);

			# ------------------------

			return $entity;
		}

		/**
		 * Get a dataset object with a custom data
		 */

		public static function getDataset(string $table, array $data = []) : Entitizer\Utils\Dataset {

			return Entitizer\Dataset::get($table, $data);
		}

		/**
		 * Get a definition object
		 */

		public static function getDefinition(string $table) : Entitizer\Utils\Definition {

			return Entitizer\Definition::get($table);
		}

		/**
		 * Get a listview object
		 */

		public static function getListview(string $table) : Entitizer\Utils\Listview {

			return Entitizer\Listview::get($table);
		}

		/**
		 * Get a treeview object
		 */

		public static function getTreeview(string $table) : Entitizer\Utils\Treeview {

			return Entitizer\Treeview::get($table);
		}
	}
}
