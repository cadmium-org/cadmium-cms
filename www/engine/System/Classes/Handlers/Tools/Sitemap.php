<?php

namespace System\Handlers\Tools {

	use System, System\Modules\Config, System\Modules\Entitizer, System\Utils\Tools, Arr, Date, DB;

	class Sitemap extends System\Frames\Tools\Sitemap {

		# Get pages

		private function getPages() {

			$pages = array();

			# Select pages

			$condition = array('visibility' => VISIBILITY_PUBLISHED, 'access' => ACCESS_PUBLIC);

			if (!(DB::select(TABLE_PAGES, 'id', $condition) && DB::last()->status)) return array();

			while (null !== ($page = DB::last()->row())) $pages[] = $page['id'];

			# Init pages

			foreach ($pages as $key => $id) {

				$page = Entitizer::page($id);

				$pages[$key] = array('canonical' => $page->canonical, 'modified' => $page->time_modified);
			}

			# ------------------------

			return Arr::subvalSort($pages, 'canonical');
		}

		# Handle request

		protected function handle() {

			# Create sitemap

			$sitemap = new Tools\Sitemap();

			# Fill sitemap

			foreach ($this->getPages() as $page) {

				$loc = (Config::get('system_url') . $page['canonical']);

				$lastmod = Date::get(DATE_FORMAT_W3C, $page['modified']);

				$sitemap->add($loc, $lastmod, FREQUENCY_WEEKLY, 0.5);
			}

			# ------------------------

			return $sitemap;
		}
	}
}
