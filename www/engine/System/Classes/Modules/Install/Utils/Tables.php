<?php

namespace Modules\Install\Utils {

	use Modules\Entitizer, Arr, DB, Language, Template;

	abstract class Tables {

		# Fill pages table

		private static function fillPagesTable() {

			# Count pages

			if (!(DB::select(TABLE_PAGES, 'COUNT(id) as count') && (DB::last()->rows === 1))) return false;

			if (intval(DB::last()->row()['count']) > 0) return true;

			# Insert initial pages

			$pages = [];

			$pages[] = ['visibility' => VISIBILITY_PUBLISHED,

				'hash' => Arr::encode(['index', 0]),

				'name' => 'index', 'title' => Language::get('INSTALL_PAGE_INDEX_TITLE'),

				'contents' => Template::block(Language::get('INSTALL_PAGE_INDEX_CONTENTS'))->contents(),

				'time_created' => REQUEST_TIME, 'time_modified' => REQUEST_TIME];

			for ($i = 1; $i <= 3; $i++) $pages[] = ['visibility' => VISIBILITY_PUBLISHED,

				'hash' => Arr::encode([('page-' . $i), 0]),

				'name' => ('page-' . $i), 'title' => (Language::get('INSTALL_PAGE_DEMO_TITLE') . ' ' . $i),

				'contents' => Template::block(Language::get('INSTALL_PAGE_DEMO_CONTENTS'))->contents(),

				'time_created' => REQUEST_TIME, 'time_modified' => REQUEST_TIME];

			# ------------------------

			return (DB::insert(TABLE_PAGES, $pages, true) && DB::last()->status);
		}

		# Fill menu table

		private static function fillMenuTable() {

			# Count menuitems

			if (!(DB::select(TABLE_MENU, 'COUNT(id) as count') && (DB::last()->rows === 1))) return false;

			if (intval(DB::last()->row()['count']) > 0) return true;

			# Insert initial menuitems

			$menu = [];

			for ($i = 1; $i <= 3; $i++) $menu[] = [

				'position' => ($i - 1), 'slug' => ('page-' . $i),

				'text' => (Language::get('INSTALL_PAGE_DEMO_TITLE') . ' ' . $i)];

			# ------------------------

			return (DB::insert(TABLE_MENU, $menu, true) && DB::last()->status);
		}

		# Create tables

		public static function create() {

			$definitions = [];

			$definitions[] = Entitizer\Definition::get(ENTITY_TYPE_PAGE);

			$definitions[] = Entitizer\Definition::get(ENTITY_TYPE_MENUITEM);

			$definitions[] = Entitizer\Definition::get(ENTITY_TYPE_VARIABLE);

			$definitions[] = Entitizer\Definition::get(ENTITY_TYPE_WIDGET);

			$definitions[] = Entitizer\Definition::get(ENTITY_TYPE_USER);

			$definitions[] = Entitizer\Definition::get(ENTITY_TYPE_USER_SECRET);

			$definitions[] = Entitizer\Definition::get(ENTITY_TYPE_USER_SESSION);

			foreach ($definitions as $definition) if (!$definition->createTable()) return false;

			# ------------------------

			return true;
		}

		# Fill tables

		public static function fill() {

			return (self::fillPagesTable() && self::fillMenuTable());
		}
	}
}
