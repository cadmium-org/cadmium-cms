<?php

namespace System\Handlers {
	
	use System, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config, System\Utils\Entity;
	use System\Utils\Lister, System\Utils\Messages, System\Utils\Pagination, System\Utils\Utils;
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
				
				$condition = ("parent_id = " . $id . " AND access <= " . Auth::user()->rank() . " AND name = '" . addslashes($name) . "'");
				
				if (!(DB::select(TABLE_PAGES, $selection, $condition, false, 1) && (DB::last()->rows === 1))) return false;
				
				$page = DB::last()->row();
				
				# Validate item
				
				$id = Number::unsigned($page['id']); $name = String::validate($page['name']);
				
				$link .= ('/' . $name); $title = String::validate($page['title']);
				
				$path[] = array('id' => $id, 'name' => $name, 'link' => $link, 'title' => $title);
			}
			
			return $path;
		}
		
		# Get page
		
		private function getPage() {
			
			# Select page
			
			$selection = array('id', 'name', 'title', 'contents');
			
			$condition = array('id' => ($this->path ? end($this->path)['id'] : 1));
			
			if (!(DB::select(TABLE_PAGES, $selection, $condition, false, 1) && (DB::last()->rows === 1))) return false;
			
			$page = DB::last()->row();
			
			# Validate page
			
			$id = Number::unsigned($page['id']); $name = String::validate($page['name']);
			
			$title = String::validate($page['title']); $contents = String::validate($page['contents']);
			
			$page = array('id' => $id, 'name' => $name, 'title' => $title, 'contents' => $contents);
			
			# ------------------------
			
			return $page;
		}
		
		# Get contents
		
		private function getContents() {
			
			$contents = Template::block('Contents/Page');
			
			# Set breadcrumbs
			
			if (count($this->path) > 1) $contents->block('breadcrumbs')->path = $this->path;
			
			else $contents->block('breadcrumbs')->disable();
			
			# Set contents
			
			$contents->contents = new Template\Utils\Block($this->page['contents']);
			
			# ------------------------
			
			return $contents;
		}
		
		# Handle request
		
		protected function handle() {
			
			if (false === ($this->path = $this->getPath())) return false;
			
			if (false === ($this->page = $this->getPage())) return false;
			
			# Fill template
			
			if ($this->page['id'] !== 1) $this->setTitle($this->page['title']);
			
			$this->setContents($this->getContents());
			
			# ------------------------
			
			return true;
		}
	}
}

?>