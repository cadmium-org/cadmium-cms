<?php

namespace System\Utils\Entity {
	
	use System\Utils\Auth, System\Utils\Lister, Arr, DB, Number, String;
	
	class Page {
		
		# Errors
		
		const ERROR_NAME							= 'PAGE_ERROR_NAME';
		
		const ERROR_PARENT							= 'PAGE_ERROR_PARENT';
		
		const ERROR_CREATE							= 'PAGE_ERROR_CREATE';
		const ERROR_SAVE							= 'PAGE_ERROR_SAVE';
		
		const ERROR_INPUT_NAME						= 'PAGE_ERROR_INPUT_NAME';
		const ERROR_INPUT_TITLE						= 'PAGE_ERROR_INPUT_TITLE';
		
		private $page = false, $path = false, $link = false, $canonical = false, $user = false, $created_id = false;
		
		# Validate data
		
		private function validateData($data) {
			
			$data['id']					= Number::unsigned($data['id']);
			
			$data['parent_id']			= Number::unsigned($data['parent_id']);
			
			$data['access']				= Number::unsigned($data['access']);
			
			$data['name']				= String::validate($data['name']);
			
			$data['title']				= String::validate($data['title']);
			
			$data['contents']			= String::validate($data['contents']);
			
			$data['description']		= String::validate($data['description']);
			
			$data['keywords']			= String::validate($data['keywords']);
			
			$data['robots_index']		= Number::binary($data['robots_index']);
			
			$data['robots_follow']		= Number::binary($data['robots_follow']);
			
			$data['user_id']			= Number::unsigned($data['user_id']);
			
			$data['time_created']		= Number::unsigned($data['time_created']);
			
			$data['time_modified']		= Number::unsigned($data['time_modified']);
			
			# ------------------------
			
			return $data;
		}
		
		# Get path
		
		private function getPath() {
			
			$id = $this->page['id']; $parent_id = $this->page['parent_id'];
			
			$name = $this->page['name']; $title = $this->page['title'];
			
			$path = array($id => array('id' => $id, 'parent_id' => $parent_id, 'name' => $name, 'title' => $title));
			
			while (0 !== $parent_id) {
				
				if (key_exists($parent_id, $path)) return false;
				
				$selection = array('id', 'parent_id', 'name', 'title'); $condition = array('id' => $parent_id);
				
				if (!(DB::select(TABLE_PAGES, $selection, $condition, false, 1) && (DB::last()->rows === 1))) return array();
				
				$page = DB::last()->row();
				
				# Validate item
				
				$id = Number::unsigned($page['id']); $parent_id = Number::unsigned($page['parent_id']);
				
				$name = String::validate($page['name']); $title = String::validate($page['title']);
				
				$path[$id] = array('id' => $id, 'parent_id' => $parent_id, 'name' => $name, 'title' => $title);
			}
						
			# ------------------------
			
			return array_reverse($path);
		}
		
		# Get link
		
		private function getLink() {
			
			return ('/' . implode('/', Arr::subvalExtract($this->path, 'name')));
		}
		
		# Get canonical
		
		private function getCanonical() {
			
			return (($this->page['id'] !== 1) ? $this->link : '');
		}
		
		# Init page with id
		
		public function init($id) {
			
			if (false !== $this->page) return true;
			
			if (0 === ($id = Number::unsigned($id))) return false;
			
			# Select page from DB
			
			$query = ("SELECT pag.id, pag.parent_id, pag.access, pag.name, pag.title, pag.contents, ") .
					 
					 ("pag.description, pag.keywords, pag.robots_index, pag.robots_follow, ") .
					 
					 ("pag.user_id, pag.time_created, pag.time_modified ") .
					 
					 ("FROM " . TABLE_PAGES . " pag WHERE pag.id = " . $id . " LIMIT 1");
			
			if (!(DB::send($query) && (DB::last()->rows === 1))) return false;
			
			$this->page = $this->validateData(DB::last()->row()); $this->path = $this->getPath();
			
			$this->link = $this->getLink(); $this->canonical = $this->getCanonical();
			
			$this->user = new User(); $this->user->init($this->page['user_id']);
			
			# ------------------------
			
			return true;
		}
		
		# Create child page
		
		public function create($data) {
			
			$parent_id = ((false !== $this->page) ? $this->page['id'] : 0);
			
			# Check dataset
			
			$dataset = array('title', 'name');
			
			foreach ($dataset as $var) if (isset($data[$var])) $$var = $data[$var]; else return false;
			
			# Check values
			
			if (false === ($title = String::validate($title))) return self::ERROR_INPUT_TITLE;
			
			if ((false === ($name = String::translit($name))) && (false === ($name = String::translit($title))))
				
				return self::ERROR_INPUT_NAME;
			
			$data['name']->value($name = String::cut(strtolower($name), CONFIG_PAGE_NAME_MAX_LENGTH));
			
			# Check name exists
			
			$condition = ("name = '" . addslashes($name) . "' AND parent_id = " . $parent_id);
			
			DB::select(TABLE_PAGES, 'id', $condition, false, 1);
			
			if (!DB::last()->status) return self::ERROR_CREATE;
			
			if (DB::last()->rows === 1) return self::ERROR_NAME;
			
			# Insert page
			
			$set['parent_id']			= $parent_id;
			$set['access']				= ACCESS_ADMINISTRATOR;
			$set['name']				= $name;
			$set['title']				= $title;
			$set['user_id']				= Auth::user()->id();
			$set['time_created']		= ENGINE_TIME;
			$set['time_modified']		= ENGINE_TIME;
			
			if (!(DB::insert(TABLE_PAGES, $set) && (DB::last()->status))) return self::ERROR_CREATE;
			
			$this->created_id = Number::unsigned(DB::last()->id);
			
			# ------------------------
			
			return true;
		}
		
		# Edit data
		
		public function edit($data) {
			
			if (false === $this->page) return false;
			
			# Check dataset
			
			$dataset = array('parent_id', 'title', 'name', 'contents', 'description', 'keywords',
							 
							 'robots_index', 'robots_follow', 'access');
			
			foreach ($dataset as $var) if (isset($data[$var])) $$var = $data[$var]; else return false;
			
			# Check values
			
			if (false === ($title = String::validate($title))) return self::ERROR_INPUT_TITLE;
			
			if ((false === ($name = String::translit($name))) && (false === ($name = String::translit($title))))
				
				return self::ERROR_INPUT_NAME;
			
			$data['name']->value($name = String::cut(strtolower($name), CONFIG_PAGE_NAME_MAX_LENGTH));
			
			# Validate values
			
			$parent_id = Number::unsigned($parent_id); $contents = String::validate($contents);
			
			$description = String::validate($description); $keywords = String::validate($keywords);
			
			$robots_index = Number::binary($robots_index); $robots_follow = Number::binary($robots_follow);
			
			$access = Lister::access($access, true);
			
			# Check parent exists
			
			if (0 !== $parent_id) {
				
				DB::select(TABLE_PAGES, 'id', array('id' => $parent_id), false, 1);
				
				if (!DB::last()->status) return self::ERROR_SAVE;
				
				if (DB::last()->rows !== 1) return self::ERROR_PARENT;
			}
			
			# Check name exists
			
			$condition = ("name = '" . addslashes($name) . "' AND parent_id = " . $parent_id . " AND id != " . $this->page['id']);
			
			DB::select(TABLE_PAGES, 'id', $condition, false, 1);
			
			if (!DB::last()->status) return self::ERROR_SAVE;
			
			if (DB::last()->rows === 1) return self::ERROR_NAME;
			
			# Update page
			
			$set['parent_id']			= $parent_id;
			$set['access']				= $access;
			$set['name']				= $name;
			$set['title']				= $title;
			$set['contents']			= $contents;
			$set['description']			= $description;
			$set['keywords']			= $keywords;
			$set['robots_index']		= $robots_index;
			$set['robots_follow']		= $robots_follow;
			$set['time_modified']		= ENGINE_TIME;
			
			$condition = array('id' => $this->page['id']);
			
			if (!(DB::update(TABLE_PAGES, $set, $condition) && DB::last()->status)) return self::ERROR_SAVE;
			
			# Init page
			
			foreach ($set as $name => $value) $this->page[$name] = $value;
			
			# ------------------------
			
			return true;
		}
					
		# Remove page
		
		public function remove() {
			
			if (false === $this->page) return false;
			
			if ($this->page['id'] === 1) return false;
			
			# Count children
			
			$condition = array('parent_id' => $this->page['id']);
			
			if (!(DB::select(TABLE_PAGES, 'COUNT(*) as count', $condition) && DB::last()->status)) return false;
			
			if (Number::unsigned(DB::last()->row()['count']) > 0) return false;
			
			# Remove page
			
			if (!(DB::delete(TABLE_PAGES, array('id' => $this->page['id'])) && DB::last()->status)) return false;
			
			$this->page = false; $this->path = false; $this->link = false; $this->user = false;
			
			# ------------------------
			
			return true;
		}
		
		# Return id
		
		public function id() {
			
			if (false === $this->page) return false;
			
			return $this->page['id'];
		}
		
		# Return parent id
		
		public function parentId() {
			
			if (false === $this->page) return false;
			
			return $this->page['parent_id'];
		}
		
		# Return access
		
		public function access() {
			
			if (false === $this->page) return false;
			
			return $this->page['access'];
		}
		
		# Return name
		
		public function name() {
			
			if (false === $this->page) return false;
			
			return $this->page['name'];
		}
		
		# Return title
		
		public function title() {
			
			if (false === $this->page) return false;
			
			return $this->page['title'];
		}
		
		# Return contents
		
		public function contents() {
			
			if (false === $this->page) return false;
			
			return $this->page['contents'];
		}
		
		# Return description
		
		public function description() {
			
			if (false === $this->page) return false;
			
			return $this->page['description'];
		}
		
		# Return keywords
		
		public function keywords() {
			
			if (false === $this->page) return false;
			
			return $this->page['keywords'];
		}
		
		# Check if robots allowed to index
		
		public function robotsIndex() {
			
			if (false === $this->page) return false;
			
			return $this->page['robots_index'];
		}
		
		# Check if robots allowed to follow
		
		public function robotsFollow() {
			
			if (false === $this->page) return false;
			
			return $this->page['robots_follow'];
		}
		
		# Return time created
		
		public function timeCreated() {
			
			if (false === $this->page) return false;
			
			return $this->page['time_created'];
		}
		
		# Return time modified
		
		public function timeModified() {
			
			if (false === $this->page) return false;
			
			return $this->page['time_modified'];
		}
		
		# Return path
		
		public function path() {
			
			return $this->path;
		}
		
		# Return link
		
		public function link() {
			
			return $this->link;
		}
		
		# Return canonical
		
		public function canonical() {
			
			return $this->canonical;
		}
		
		# Return user
		
		public function user() {
			
			return $this->user;
		}
		
		# Return id of last created child
		
		public function createdId() {
			
			return $this->created_id;
		}
	}
}

?>