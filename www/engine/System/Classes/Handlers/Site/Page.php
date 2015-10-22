<?php

namespace System\Handlers\Site {

	use System, System\Modules\Auth, System\Modules\Entitizer, System\Utils\View, DB, Template;

	class Page extends System\Frames\Site\Section {

		private $page = false;

		# Get path

		private function getPath() {

			$path = []; $id = 0; $link = INSTALL_PATH;

			foreach ($this->path as $name) {

				# Select item

				$selection = ['id', 'name', 'title'];

				$access = (Auth::check() ? Auth::user()->rank : RANK_GUEST);

				$condition = ("parent_id = " . $id . " AND visibility = " . VISIBILITY_PUBLISHED . " ") .

				             ("AND access <= " . $access . " AND name = '" . addslashes($name) . "'");

				if (!(DB::select(TABLE_PAGES, $selection, $condition, null, 1) && (DB::last()->rows === 1))) return false;

				$page = DB::last()->row();

				# Validate item

				$id = intabs($page['id']); $link .= ('/' . strval($page['name'])); $title = strval($page['title']);

				$path[] = ['id' => $id, 'link' => $link, 'title' => $title];
			}

			# ------------------------

			return $path;
		}

		# Get contents

		private function getContents() {

			$contents = View::get('Blocks\Page');

			# Set breadcrumbs

			if (count($this->path) > 1) $contents->block('breadcrumbs')->path = $this->path;

			else $contents->block('breadcrumbs')->disable();

			# Set contents

			$contents->contents = Template::block($this->page->contents);

			# ------------------------

			return $contents;
		}

		# Handle request

		protected function handle() {

			if (false !== ($path = $this->getPath())) $this->path = $path; else return false;

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
