<?php

namespace System\Modules\Install\Utils {

	use System\Modules\Entitizer, DB, Language;

	abstract class Tables {

		# Fill pages table

		private static function fillPagesTable() {

			# Count pages

			if (!(DB::select(TABLE_PAGES, 'COUNT(*) as count') && (DB::last()->rows === 1))) return false;

			if (intabs(DB::last()->row()['count']) > 0) return true;

			# Insert initial pages

			$pages = array();

			$pages[] = array('visibility' => VISIBILITY_PUBLISHED,

				'name' => 'index', 'title' => Language::get('INSTALL_PAGE_INDEX_TITLE'),

				'contents' => Language::get('INSTALL_PAGE_INDEX_CONTENTS'),

				'time_created' => REQUEST_TIME, 'time_modified' => REQUEST_TIME);

			for ($i = 1; $i <= 3; $i++) $pages[] = array('visibility' => VISIBILITY_PUBLISHED,

				'name' => ('page-' . $i), 'title' => (Language::get('INSTALL_PAGE_DEMO_TITLE') . ' ' . $i),

				'contents' => Language::get('INSTALL_PAGE_DEMO_CONTENTS'),

				'time_created' => REQUEST_TIME, 'time_modified' => REQUEST_TIME);

			# ------------------------

			return (DB::insert(TABLE_PAGES, $pages, true) && DB::last()->status);
		}

		# Fill menu table

		private static function fillMenuTable() {

			# Count menuitems

			if (!(DB::select(TABLE_MENU, 'COUNT(*) as count') && (DB::last()->rows === 1))) return false;

			if (intabs(DB::last()->row()['count']) > 0) return true;

			# Insert initial menuitems

			$menu = array();

			for ($i = 1; $i <= 3; $i++) $menu[] = array (

				'position' => ($i - 1), 'link' => ('/page-' . $i),

				'text' => (Language::get('INSTALL_PAGE_DEMO_TITLE') . ' ' . $i));

			# ------------------------

			return (DB::insert(TABLE_MENU, $menu, true) && DB::last()->status);
		}

        # Create tables

		public static function create() {

			$definitions = array();

			$definitions[] = Entitizer::definition(ENTITY_TYPE_PAGE);

			$definitions[] = Entitizer::definition(ENTITY_TYPE_MENUITEM);

			$definitions[] = Entitizer::definition(ENTITY_TYPE_USER);

			$definitions[] = Entitizer::definition(ENTITY_TYPE_USER_SECRET);

			$definitions[] = Entitizer::definition(ENTITY_TYPE_USER_SESSION);

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
