<?php

namespace Modules\Tools\Handler {

	use Frames, Modules\Entitizer, Modules\Tools, Date, DB, Explorer;

	class Sitemap extends Frames\Tools\Sitemap {

		# Get last modified

		private function getLastModified() {

			$selection = 'MAX(time_modified) as last_modified';

			if (!(DB::select(TABLE_PAGES, $selection) && (DB::getLast()->rows === 1))) return 0;

			# ------------------------

			return intval(DB::getLast()->getRow()['last_modified']);
		}

		# Get pages

		private function getPages() {

			$selection = ['id', 'slug', 'time_modified'];

			$condition = ['visibility' => VISIBILITY_PUBLISHED, 'access' => ACCESS_PUBLIC, 'locked' => 0];

			if (!(DB::select(TABLE_PAGES, $selection, $condition, 'slug') && DB::getLast()->status)) return;

			# ------------------------

			while (null !== ($data = DB::getLast()->getRow())) yield Entitizer::dataset(TABLE_PAGES, $data);
		}

		# Handle request

		protected function handle() {

			# Create sitemap

			$sitemap = new Tools\Sitemap();

			# Load sitemap

			$file_name = (DIR_SYSTEM_DATA . 'Sitemap.xml');

			$modified = Explorer::getModified($file_name);

			if ((false !== $modified) && ($modified > $this->getLastModified())) {

				if (false !== $sitemap->load($file_name)) return $sitemap;
			}

			# Fill sitemap

			foreach ($this->getPages() as $page) {

				$loc = $page->canonical; $lastmod = Date::get(DATE_FORMAT_W3C, $page->time_modified);

				$sitemap->add($loc, $lastmod, FREQUENCY_WEEKLY, 0.5);
			}

			# Save sitemap

			$sitemap->save($file_name);

			# ------------------------

			return $sitemap;
		}
	}
}
