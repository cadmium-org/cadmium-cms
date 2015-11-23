<?php

namespace System\Handlers\Tools {

	use System, System\Modules\Entitizer, System\Modules\Settings, System\Utils\Tools, Arr, Date, DB;

	class Sitemap extends System\Frames\Tools\Sitemap {

		# Get last modified

		private function getLastModified() {

			$selection = 'MAX(time_modified) as last_modified';

			if (!(DB::select(TABLE_PAGES, $selection) && (DB::last()->rows === 1))) return 0;

			# ------------------------

			return intval(DB::last()->row()['last_modified']);
		}

		# Get pages

		private function getPages() {

			$pages = [];

			# Select pages

			$condition = ['visibility' => VISIBILITY_PUBLISHED, 'access' => ACCESS_PUBLIC];

			if (!(DB::select(TABLE_PAGES, 'id', $condition) && DB::last()->status)) return [];

			while (null !== ($page = DB::last()->row())) $pages[] = $page['id'];

			# Init pages

			foreach ($pages as $key => $id) {

				$page = Entitizer::page($id);

				$pages[$key] = ['canonical' => $page->canonical, 'modified' => $page->time_modified];
			}

			# ------------------------

			return Arr::sortby($pages, 'canonical');
		}

		# Handle request

		protected function handle() {

			# Create sitemap

			$sitemap = new Tools\Sitemap();

			# Get last modification time

			$last_modified = $this->getLastModified();

			if ($sitemap->load($last_modified)) return $sitemap;

			# Fill sitemap

			foreach ($this->getPages() as $page) {

				$loc = (Settings::get('system_url') . $page['canonical']);

				$lastmod = Date::get(DATE_FORMAT_W3C, $page['modified']);

				$sitemap->add($loc, $lastmod, FREQUENCY_WEEKLY, 0.5);
			}

			# Save sitemap

			$sitemap->save();

			# ------------------------

			return $sitemap;
		}
	}
}
