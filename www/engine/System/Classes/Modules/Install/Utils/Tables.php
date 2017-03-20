<?php

/**
 * @package Cadmium\System\Modules\Install
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Install\Utils {

	use Modules\Entitizer, DB, Language, Template;

	abstract class Tables {

		/**
		 * Get the list of entities definitions
		 *
		 * @param $reverse tells to return the definitions in a reverse order (necessary for removing database tables)
		 */

		private static function getDefinitions(bool $reverse) : array {

			$definitions = [];

			$definitions[] = Entitizer::getDefinition(TABLE_PAGES);

			$definitions[] = Entitizer::getDefinition(TABLE_MENU);

			$definitions[] = Entitizer::getDefinition(TABLE_VARIABLES);

			$definitions[] = Entitizer::getDefinition(TABLE_WIDGETS);

			$definitions[] = Entitizer::getDefinition(TABLE_USERS);

			$definitions[] = Entitizer::getDefinition(TABLE_USERS_SECRETS);

			$definitions[] = Entitizer::getDefinition(TABLE_USERS_SESSIONS);

			# ------------------------

			return ($reverse ? array_reverse($definitions) : $definitions);
		}

		/**
		 * Fill in a relations table
		 *
		 * @param $table        a basic table
		 * @param $max_id       a number of entries to insert
		 *
		 * @return bool : true on success or false on failure
		 */

		private static function fillRelationsTable(string $table, int $max_id) : bool {

			$relations = [];

			for ($id = 1; $id <= $max_id; $id++) {

				$relations[] = ['ancestor' => $id, 'descendant' => $id, 'depth' => 0];
			}

			# ------------------------

			return (DB::insert($table, $relations, true, true) && DB::getLast()->status);
		}

		/**
		 * Fill in the pages table with the default values
		 *
		 * @return bool : true on success or false on failure
		 */

		private static function fillPagesTable() : bool {

			# Count pages

			$count = DB::count(TABLE_PAGES);

			if (false === $count) return false; else if ($count > 0) return true;

			# Process dataset

			$pages = [['id' => 1, 'visibility' => VISIBILITY_PUBLISHED,

				'locked' => false, 'slug' => 'index', 'name' => 'index',

				'title' => Language::get('INSTALL_PAGE_INDEX_TITLE'),

				'contents' => Template::createBlock(Language::get('INSTALL_PAGE_INDEX_CONTENTS'))->getContents(),

				'time_created' => REQUEST_TIME, 'time_modified' => REQUEST_TIME]];

			for ($id = 2; $id <= 4; $id++) $pages[] = ['id' => $id, 'visibility' => VISIBILITY_PUBLISHED,

				'locked' => false, 'slug' => ('page-' . ($id - 1)), 'name' => ('page-' . ($id - 1)),

				'title' => (Language::get('INSTALL_PAGE_DEMO_TITLE') . ' ' . ($id - 1)),

				'contents' => Template::createBlock(Language::get('INSTALL_PAGE_DEMO_CONTENTS'))->getContents(),

				'time_created' => REQUEST_TIME, 'time_modified' => REQUEST_TIME];

			# Process insertion

			if (!(DB::insert(TABLE_PAGES, $pages, true) && DB::getLast()->status)) return false;

			self::fillRelationsTable(TABLE_PAGES_RELATIONS, count($pages));

			# ------------------------

			return true;
		}

		/**
		 * Fill in the menu table with the default values
		 *
		 * @return bool : true on success or false on failure
		 */

		private static function fillMenuTable() : bool {

			# Count menuitems

			$count = DB::count(TABLE_MENU);

			if (false === $count) return false; else if ($count > 0) return true;

			# Process dataset

			$menu = [];

			for ($id = 1; $id <= 3; $id++) $menu[] = [

				'id' => $id, 'active' => true, 'position' => ($id - 1), 'slug' => ('page-' . $id),

				'text' => (Language::get('INSTALL_PAGE_DEMO_TITLE') . ' ' . $id)];

			# Process insertion

			if (!(DB::insert(TABLE_MENU, $menu, true) && DB::getLast()->status)) return false;

			self::fillRelationsTable(TABLE_MENU_RELATIONS, count($menu));

			# ------------------------

			return true;
		}

		/**
		 * Create the tables
		 *
		 * @return bool : true if all of the tables were successfully created, otherwise false
		 */

		public static function create() : bool {

			$definitions = self::getDefinitions(false);

			foreach ($definitions as $definition) if (!$definition->createTables()) return false;

			# ------------------------

			return true;
		}

		/**
		 * Remove the tables
		 *
		 * @return bool : true if all of the tables were successfully removed, otherwise false
		 */

		public static function remove() : bool {

			$definitions = self::getDefinitions(true);

			foreach ($definitions as $definition) if (!$definition->removeTables()) return false;

			# ------------------------

			return true;
		}

		/**
		 * Fill in the tables with the default values
		 *
		 * @return bool : true if all of the tables were successfully filled in, otherwise false
		 */

		public static function fill() : bool {

			return (self::fillPagesTable() && self::fillMenuTable());
		}
	}
}
