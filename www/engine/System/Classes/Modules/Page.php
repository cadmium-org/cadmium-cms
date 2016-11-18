<?php

namespace Modules {

	use Frames, Utils\SEO, Utils\View, Template;

	class Page extends Frames\Site\Area\Common {

		private $page = null, $path = [];

		# Get contents

		private function getContents() {

			$contents = View::get('Blocks/Page');

			# Set breadcrumbs

			if (count($this->path) <= 1) $contents->getBlock('breadcrumbs')->disable();

			else $contents->getBlock('breadcrumbs')->path = $this->path;

			# Set contents

			$contents->contents = Template::createBlock($this->page->contents);

			# ------------------------

			return $contents;
		}

		# Handle request

		protected function handle() {

			# Get page entity

			$this->page = Entitizer::get(TABLE_PAGES);

			# Init page by requested url

			$slug = $this->url->getSlug();

			if ('' !== $slug) $this->page->initBySlug($slug); else $this->page->init(1);

			# Display error if not found

			if (0 === $this->page->id) return false;

			# Get path

			if (false !== ($path = $this->page->path())) $this->path = $path;

			# Set data

			if ($this->page->id !== 1) SEO::title($this->page->title); else $this->layout = 'Index';

			SEO::description        ($this->page->description);
			SEO::keywords           ($this->page->keywords);
			SEO::robotsIndex        ($this->page->robots_index);
			SEO::robotsFollow       ($this->page->robots_follow);
			SEO::canonical          ($this->page->canonical);

			# ------------------------

			return $this->getContents();
		}
	}
}
