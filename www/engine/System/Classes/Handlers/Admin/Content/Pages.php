<?php

namespace System\Handlers\Admin\Content {

	use Error, System, System\Forms, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config;
	use System\Utils\Entitizer, System\Utils\Extend, System\Utils\Lister, System\Utils\Messages;
	use System\Utils\Pagination, System\Utils\Requirements, System\Utils\Utils, System\Utils\View;

	use Agent, Arr, Cookie, Date, DB, Explorer, Form, Geo\Country, Geo\Timezone;
	use Headers, Language, Mailer, Number, Request, Session, String, Tag, Template, Url, Validate;

	class Pages extends System\Frames\Admin\Listview\Pages {

		private $page = null, $form = null;

		# Get path

		private function getPath() {

			$path = $this->page->path; $count = count($path);

			foreach (array_keys($path) as $key) {

				$path[$key]['class'] = (($key === ($count - 1)) ? 'active section' : 'section');
			}

			return $path;
		}

		# Get contents

		private function getContents() {

			$contents = View::get('Blocks/Contents/Content/Pages/Main');

			# Set general

			$contents->id = $this->page->id;

			$contents->parent_id = $this->page->parent_id;

			# Set path

			$contents->path = ($path = $this->getPath());

			# Set parent title

			$parent_title = (($this->page->parent_id !== 0) ? $path[count($path) - 2]['title'] : ('- ' . Language::get('NONE')));

			$contents->block('parent')->title = $parent_title;

			# Set form

			$this->form->implement($contents);

			# ------------------------

			return $contents;
		}

		# Handle request

		protected function handle() {

			if (null === ($id = Request::get('id'))) return $this->handleList();

			# Create page

			$this->page = Entitizer::manager(ENTITY_TYPE_PAGE, $id);

			if (0 === $this->page->id) return $this->handleList(true);

			# Create form

		 	$this->form = new Forms\Admin\Content\Pages\Edit($this->page);

			# Post form

			if (false !== ($post = $this->form->post())) {

				if ($this->form->errors()) Messages::error(Language::get('FORM_ERROR_REQUIRED'));

				else if (true !== ($result = $this->page->edit($post))) Messages::error(Language::get($result));

				else Request::redirect('/admin/content/pages?id=' . $this->page->id . '&submitted');

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

			foreach ($fieldset as $name) $form->virtual($name);

			if (false === ($post = $form->post())) return false;

			# Create page

			$this->page = Entitizer::page($post['id']);

			# Process list

			if ($post['action'] == 'list') return $this->handleListAjax($this->page->id);

			# Process remove

			if ($post['action'] == 'remove') {

				if (0 === $this->page->id) return Ajax::error(Language::get('PAGES_ITEM_NOT_FOUND'));

				return $this->page->remove();
			}

			# ------------------------

			return false;
		}
	}
}
