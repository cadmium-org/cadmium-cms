<?php

namespace Modules\Install\Utils {

	use Modules\Entitizer, Modules\Informer, DB, Language, Template;

	abstract class Tables {

		# Get definitions list

		private static function getDefinitions(bool $reverse) {

			$definitions = [];

			$definitions[] = Entitizer::definition(TABLE_PAGES);

			$definitions[] = Entitizer::definition(TABLE_MENU);

			$definitions[] = Entitizer::definition(TABLE_VARIABLES);

			$definitions[] = Entitizer::definition(TABLE_WIDGETS);

			$definitions[] = Entitizer::definition(TABLE_USERS);

			$definitions[] = Entitizer::definition(TABLE_USERS_SECRETS);

			$definitions[] = Entitizer::definition(TABLE_USERS_SESSIONS);

			# ------------------------

			return ($reverse ? array_reverse($definitions) : $definitions);
		}

		# Fill specific relations table

		private static function fillRelationsTable(string $table, int $max_id) {

			$relations = [];

			for ($id = 1; $id <= $max_id; $id++) {

				$relations[] = ['ancestor' => $id, 'descendant' => $id, 'depth' => 0];
			}

			# ------------------------

			return (DB::insert($table, $relations, true, true) && DB::getLast()->status);
		}

		# Fill pages table

		private static function fillPagesTable() {

			# Count pages

			$count = Informer::countEntries(TABLE_PAGES, true);

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

			self::fillRelationsTable(TABLE_PAGES_RELATIONS, 4);

			# ------------------------

			return true;
		}

		# Fill menu table

		private static function fillMenuTable() {

			# Count menuitems

			$count = Informer::countEntries(TABLE_MENU, true);

			if (false === $count) return false; else if ($count > 0) return true;

			# Process dataset

			$menu = [];

			for ($id = 1; $id <= 3; $id++) $menu[] = [

				'id' => $id, 'active' => true, 'position' => ($id - 1), 'slug' => ('page-' . $id),

				'text' => (Language::get('INSTALL_PAGE_DEMO_TITLE') . ' ' . $id)];

			# Process insertion

			if (!(DB::insert(TABLE_MENU, $menu, true) && DB::getLast()->status)) return false;

			self::fillRelationsTable(TABLE_MENU_RELATIONS, 3);

			# ------------------------

			return true;
		}

		# Create tables

		public static function create() {

			$definitions = self::getDefinitions(false);

			foreach ($definitions as $definition) if (!$definition->createTables()) return false;

			# ------------------------

			return true;
		}

		# Remove tables

		public static function remove() {

			$definitions = self::getDefinitions(true);

			foreach ($definitions as $definition) if (!$definition->removeTables()) return false;

			# ------------------------

			return true;
		}

		# Fill tables

		public static function fill() {

			return (self::fillPagesTable() && self::fillMenuTable());
		}
	}
}
