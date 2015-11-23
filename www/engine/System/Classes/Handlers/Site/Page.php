<?php

namespace System\Handlers\Site {

	use System, System\Modules\Auth, System\Modules\Entitizer, System\Utils\View, DB, Template;

	class Page extends System\Frames\Site\Section {

		private $path = [], $page = false;

		# Get path

		private function getPath() {

			$parent_id = 0; $link = INSTALL_PATH; $path = [];

			# Page validator

			$page = function(int $id, string $name, string $title) use (&$parent_id, &$link) {

				$parent_id = $id; $link .= ('/' . $name);

				return ['id' => $id, 'link' => $link, 'title' => $title];
			};

			# Process url path items

			foreach ($this->url->path() as $name) {

				$selection = ['id', 'name', 'title'];

				$access = (Auth::check() ? Auth::user()->rank : RANK_GUEST);

				$condition = ("parent_id = " . $parent_id . " AND visibility = " . VISIBILITY_PUBLISHED . " ") .

				             ("AND access <= " . $access . " AND name = '" . addslashes($name) . "'");

				if (!(DB::select(TABLE_PAGES, $selection, $condition, null, 1) && (DB::last()->rows === 1))) return false;

				$path[] = $page(...array_values(DB::last()->row()));
			}

			# ------------------------

			return $path;
		}

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

			if (false === ($path = $this->getPath())) return false;

			$this->path = $path;

			# Create page

			$this->page = Entitizer::page($this->path ? end($this->path)['id'] : 1);

			if (0 === $this->page->id) return false;

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
