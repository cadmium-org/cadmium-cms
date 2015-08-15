<?php

namespace System\Handlers\Site {

	use Error, System, System\Forms, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config;
	use System\Utils\Entity, System\Utils\Extend, System\Utils\Lister, System\Utils\Messages;
	use System\Utils\Pagination, System\Utils\Requirements, System\Utils\Utils, System\Utils\View;

	use Agent, Arr, Cookie, Date, DB, Explorer, Form, Geo\Country, Geo\Timezone;
	use Headers, Language, Mailer, Number, Request, Session, String, Tag, Template, Url, Validate;

	class Page extends System\Frames\Site\Handler {

		private $page = false;

		# Get path

		private function getPath() {

			$path = array(); $id = 0; $link = '';

			foreach ($this->path as $name) {

				# Select item

				$selection = array('id', 'name', 'title');

				$access = (Auth::check() ? Auth::user()->rank : RANK_GUEST);

				$condition = ("parent_id = " . $id . " AND visibility = " . VISIBILITY_PUBLISHED . " ") .

				             ("AND access <= " . $access . " AND name = '" . addslashes($name) . "'");

				if (!(DB::select(TABLE_PAGES, $selection, $condition, null, 1) && (DB::last()->rows === 1))) return false;

				$page = DB::last()->row();

				# Validate item

				$id = intabs($page['id']); $link .= ('/' . strval($page['name'])); $title = strval($page['title']);

				$path[] = array('id' => $id, 'link' => $link, 'title' => $title);
			}

			return $path;
		}

		# Get contents

		private function getContents() {

			$contents = View::get('Blocks/Contents/Page');

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

			if (false === ($path = $this->getPath())) return false;

			$this->path = $path;

			# Create page

			$this->page = Entity\Factory::page($this->path ? end($this->path)['id'] : 1);

			if (0 === $this->page->id) return false;

			$description = $this->page->description; $keywords = $this->page->keywords;

			# Fill template

			if ($this->page->id !== 1) $this->setTitle($this->page->title);

			else $this->setLayout('Index');

			$this->setContents($this->getContents());

			# Set SEO data

			Template::description   ((false !== $description) ? $description : CONFIG_SITE_DESCRIPTION);

			Template::keywords      ((false !== $keywords) ? $keywords : CONFIG_SITE_KEYWORDS);

			Template::robots        ($this->page->robots_index, $this->page->robots_follow);

			Template::canonical     (CONFIG_SYSTEM_URL, $this->page->canonical);

			# ------------------------

			return true;
		}
	}
}
