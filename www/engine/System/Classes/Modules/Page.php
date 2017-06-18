<?php

/**
 * @package Cadmium\System\Modules\Page
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules {

	use Frames, Utils\SEO, Utils\View, Template;

	class Page extends Frames\Site\Area\Common {

		private $page = null, $path = [];

		/**
		 * Get the contents block
		 */

		private function getContents() : Template\Block {

			$contents = View::get('Blocks/Page');

			# Set breadcrumbs

			if (count($this->path) <= 1) $contents->getBlock('breadcrumbs')->disable();

			else $contents->getBlock('breadcrumbs')->path = $this->path;

			# Set contents

			$contents->contents = Template::createBlock($this->page->contents);

			# ------------------------

			return $contents;
		}

		/**
		 * Handle the request
		 *
		 * @return Template\Block|false : a block object on success or false if a page was not found
		 */

		protected function handle() {

			# Get page entity

			$this->page = Entitizer::get(TABLE_PAGES);

			# Init page by requested url

			$slug = $this->_url->getSlug();

			if ('' !== $slug) $this->page->initBySlug($slug); else $this->page->init(1);

			# Display error if not found

			if (0 === $this->page->id) return false;

			# Get path

			if (false !== ($path = $this->page->getPath())) $this->path = $path;

			# Set data

			if ($this->page->id !== 1) SEO::set('title', $this->page->title); else $this->_layout = 'Index';

			SEO::set('description',         $this->page->description);
			SEO::set('keywords',            $this->page->keywords);
			SEO::set('robots_index',        $this->page->robots_index);
			SEO::set('robots_follow',       $this->page->robots_follow);
			SEO::set('canonical',           $this->page->canonical);

			# ------------------------

			return $this->getContents();
		}
	}
}
