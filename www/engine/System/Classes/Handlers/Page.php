<?php

namespace System\Handlers {

	use Error, Warning, System, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config, System\Utils\Entity;
	use System\Utils\Extend, System\Utils\Lister, System\Utils\Messages, System\Utils\Pagination;
	use System\Utils\Requirements, System\Utils\Utils;

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

				if (!(DB::select(TABLE_PAGES, $selection, $condition, false, 1) && (DB::last()->rows === 1))) return false;

				$page = DB::last()->row();

				# Validate item

				$id = Number::unsigned($page['id']); $name = String::validate($page['name']);

				$link .= ('/' . $name); $title = String::validate($page['title']);

				$path[] = array('id' => $id, 'name' => $name, 'link' => $link, 'title' => $title);
			}

			return $path;
		}

		# Get contents

		private function getContents() {

			$contents = Template::block('Contents/Page');

			# Set breadcrumbs

			if (count($this->path) > 1) $contents->block('breadcrumbs')->path = $this->path;

			else $contents->block('breadcrumbs')->disable();

			# Set contents

			$contents->contents = new Template\Utils\Block($this->page->contents);

			# ------------------------

			return $contents;
		}

		# Handle request

		protected function handle() {

			if (false === ($this->path = $this->getPath())) return false;

			# Create page

			$this->page = Entity\Factory::page($this->path ? end($this->path)['id'] : 1);

			if (false === $this->page->id) return false;

			$description = $this->page->description; $keywords = $this->page->keywords;

			# Fill template

			if ($this->page->id !== 1) $this->setTitle($this->page->title);

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
