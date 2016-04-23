<?php

namespace Handlers\Tools {

	use Frames, Modules\Entitizer, Modules\Settings, Utils\Tools, Arr, Date, DB;

	class Sitemap extends Frames\Tools\Sitemap {

		# Get last modified

		private function getLastModified() {

			$selection = 'MAX(time_modified) as last_modified';

			if (!(DB::select(TABLE_PAGES, $selection) && (DB::last()->rows === 1))) return 0;

			# ------------------------

			return intval(DB::last()->row()['last_modified']);
		}

		# Get pages

		private function getPages() {

			$selection = ['id', 'slug', 'time_modified'];

			$condition = ['visibility' => VISIBILITY_PUBLISHED, 'access' => ACCESS_PUBLIC, 'locked' => 0];

			if (!(DB::select(TABLE_PAGES, $selection, $condition, 'slug') && DB::last()->status)) return;

			# ------------------------

			while (null !== ($page = DB::last()->row())) yield Entitizer::dataset(TABLE_PAGES, $page);
		}

		# Handle request

		protected function handle() {

			# Create sitemap

			$sitemap = new Tools\Sitemap();

			# Get last modification time

			if ($sitemap->load($this->getLastModified())) return $sitemap;

			# Fill sitemap

			foreach ($this->getPages() as $page) {

				$loc = $page->canonical; $lastmod = Date::get(DATE_FORMAT_W3C, $page->time_modified);

				$sitemap->add($loc, $lastmod, FREQUENCY_WEEKLY, 0.5);
			}

			# Save sitemap

			$sitemap->save();

			# ------------------------

			return $sitemap;
		}
	}
}
