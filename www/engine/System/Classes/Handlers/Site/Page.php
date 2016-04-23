<?php

namespace Handlers\Site {

	use Frames, Modules\Entitizer, Utils\View, Template;

	class Page extends Frames\Site\Section {

		private $page = null, $path = [];

		# Get contents

		private function getContents() {

			$contents = View::get('Blocks\Page');

			# Set breadcrumbs

			if (count($this->path) <= 1) $contents->block('breadcrumbs')->disable();

			else $contents->block('breadcrumbs')->path = $this->path;

			# Set contents

			$contents->contents = Template::block($this->page->contents);

			# ------------------------

			return $contents;
		}

		# Handle request

		protected function handle() {

			# Get page entity

			$this->page = Entitizer::get(TABLE_PAGES);

			# Init page by requested url

			$slug = implode('/', $this->url->path());

			if ('' !== $slug) $this->page->initBySlug($slug); else $this->page->init(1);

			# Display error if not found

			if (0 === $this->page->id) return false;

			# Get path

			if (false !== ($path = $this->page->path())) $this->path = $path;

			# Set data

			if ($this->page->id !== 1) $this->title = $this->page->title; else $this->layout = 'Index';

			$this->description      = $this->page->description;
			$this->keywords         = $this->page->keywords;
			$this->robots_index     = $this->page->robots_index;
			$this->robots_follow    = $this->page->robots_follow;
			$this->canonical        = $this->page->canonical;

			# ------------------------

			return $this->getContents();
		}
	}
}
