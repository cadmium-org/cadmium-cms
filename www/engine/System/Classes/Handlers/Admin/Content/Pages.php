<?php

namespace System\Handlers\Admin\Content {
	
	use System, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config, System\Utils\Entity;
	use System\Utils\Lister, System\Utils\Messages, System\Utils\Pagination, System\Utils\Utils;
	use Agent, Arr, Cookie, Date, DB, Explorer, Form, Geo\Country, Geo\Timezone;
	use Headers, Language, Mailer, Number, Request, Session, String, Tag, Template, Url, Validate;
	
	class Pages extends System\Frames\Admin\Listview\Pages {
		
		private $page = false, $form = false;
		
		# Get path
		
		private function getPath() {
			
			$path = $this->page->path(); $count = count($path);
			
			foreach (array_keys($path) as $key) {
				
				$path[$key]['class'] = (($key === ($count - 1)) ? 'active section' : 'section');
			}
			
			return $path;
		}
		
		# Get contents
		
		private function getContents() {
			
			$contents = Template::block('Contents/Content/Pages/Main');
			
			# Set general
			
			$contents->id = $this->page->id();
			
			$contents->parent_id = $this->page->parentId();
			
			# Set path
			
			$contents->path = ($path = $this->getPath());
			
			# Set parent title
			
			$parent_title = (($this->page->parentId() !== 0) ? $path[count($path) - 2]['title'] : ('- ' . Language::get('NONE')));
			
			$contents->block('parent')->title = $parent_title;
			
			# Set form
			
			foreach ($this->form->fields() as $name => $block) $contents->block(('field_' . $name), $block);
			
			# ------------------------
			
			return $contents;
		}
		
		# Handle request
		
		protected function handle() {
			
			# Create page
			
			$this->page = new Entity\Page();
			
			if ((null !== ($id = Request::get('id'))) && (false === $this->page->init($id))) {
				
				Messages::error(Language::get('PAGES_ITEM_NOT_FOUND'));
			}
			
			if (false === $this->page->id()) return $this->handleList();
			
			# Create form
			
			$this->form = new Form('page'); $fieldset = $this->form->fieldset();
			
			# Add form fields
			
			$fieldset->hidden		('parent_id', $this->page->parentId());
			
			$fieldset->text			('title', $this->page->title(), CONFIG_PAGE_TITLE_MAX_LENGTH);
			
			$fieldset->text			('name', $this->page->name(), CONFIG_PAGE_NAME_MAX_LENGTH);
			
			$fieldset->select		('access', $this->page->access(), Lister::access());
			
			$fieldset->textarea		('description', $this->page->description(), CONFIG_PAGE_DESCRIPTION_MAX_LENGTH);
			
			$fieldset->text			('keywords', $this->page->keywords(), CONFIG_PAGE_KEYWORDS_MAX_LENGTH);
			
			$fieldset->checkbox		('robots_index', $this->page->robotsIndex());
			
			$fieldset->checkbox		('robots_follow', $this->page->robotsFollow());
			
			$fieldset->textarea		('contents', $this->page->contents());
			
			# Post form
			
			if (false !== ($post = $this->form->post())) {
				
				if (true !== ($result = $this->page->edit($post))) Messages::error(Language::get($result));
				
				else Request::redirect('/admin/content/pages?id=' . $this->page->id() . '&submitted');
				
			} else if (null !== ($submitted = Request::get('submitted'))) {
				
				if ($submitted === 'create') Messages::success(Language::get('PAGE_SUCCESS_CREATE'));
				
				else Messages::success(Language::get('PAGE_SUCCESS_SAVE'));
			}
			
			# Fill template
			
			$this->setTitle(Language::get('TITLE_CONTENT_PAGES_EDIT'));
			
			$this->setContents($this->getContents());
			
			# ------------------------
			
			return true;
		}
		
		# Handle ajax request
		
		public function handleAjax() {
			
			# Process form
			
			$form = new Form('ajax'); $fieldset = array('action', 'id');
			
			foreach ($fieldset as $name) $form->fieldset()->virtual($name);
			
			if (false === ($post = $form->post())) return false;
			
			# Create page
			
			$this->page = new Entity\Page(); $this->page->init($post['id']);
			
			# Process list
			
			if ($post['action'] == 'list') return $this->handleListAjax($this->page->id());
			
			# Process remove
			
			if ($post['action'] == 'remove') {
				
				if (false === $this->page->id()) return Ajax::error(Language::get('PAGES_ITEM_NOT_FOUND'));
				
				return $this->page->remove();
			}
			
			# ------------------------
			
			return false;
		}
	}
}

?>