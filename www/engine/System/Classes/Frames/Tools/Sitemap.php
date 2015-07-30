<?php

namespace System\Frames\Tools {

	use System, System\Utils\Entity, System\Utils\Tools, Arr, Date, DB;

	class Sitemap extends System\Frames\Main {

		# Get pages

		private function getPages() {

			$pages = array();

			$condition = array('visibility' => VISIBILITY_PUBLISHED, 'access' => ACCESS_PUBLIC);

			if (!(DB::select(TABLE_PAGES, 'id', $condition) && DB::last()->status)) return false;

			while (null !== ($page = DB::last()->row())) $pages[] = $page['id'];

			foreach ($pages as $key => $id) {

				$page = Entity\Factory::page($id);

				$pages[$key] = array('canonical' => $page->canonical, 'modified' => $page->time_modified);
			}

			return Arr::subvalSort($pages, 'canonical');
		}

		# Sitemap main method

		protected function main() {

			$sitemap = new Tools\Sitemap();

			if (false !== ($pages = $this->getPages())) foreach ($pages as $page) {

				$loc = (CONFIG_SYSTEM_URL . $page['canonical']);

				$lastmod = Date::get(DATE_FORMAT_W3C, $page['modified']);

				$sitemap->add($loc, $lastmod, FREQUENCY_WEEKLY, 0.5);
			}

			$sitemap->output();
		}
	}
}
