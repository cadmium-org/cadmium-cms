<?php

namespace System\Handlers\Admin\Content {

	use Error, System, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config, System\Utils\Entity;
	use System\Utils\Extend, System\Utils\Lister, System\Utils\Messages, System\Utils\Pagination;
	use System\Utils\Requirements, System\Utils\Utils;

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

			$contents = Template::block('Contents/Content/Pages/Main');

			# Set general

			$contents->id = $this->page->id;

			$contents->parent_id = $this->page->parent_id;

			# Set path

			$contents->path = ($path = $this->getPath());

			# Set parent title

			$parent_title = (($this->page->parent_id !== 0) ? $path[count($path) - 2]['title'] : ('- ' . Language::get('NONE')));

			$contents->block('parent')->title = $parent_title;

			# Set form

			foreach ($this->form->fields() as $name => $block) $contents->block(('field_' . $name), $block);

			# ------------------------

			return $contents;
		}

		# Handle request

		protected function handle() {

			if (null === ($id = Request::get('id'))) return $this->handleList();

			# Create page

			$this->page = new Entity\Type\Page\Manager($id);

			if (0 === $this->page->id) return $this->handleList(true);

			# Create form

			$this->form = new Form('page');

			# Add form fields

			$form->hidden       ('parent_id', $this->page->parent_id);

			$this->form->input        ('title', $this->page->title, FORM_INPUT_TEXT, CONFIG_PAGE_TITLE_MAX_LENGTH, '', FORM_FIELD_REQUIRED);

			$this->form->input        ('name', $this->page->name, FORM_INPUT_TEXT, CONFIG_PAGE_NAME_MAX_LENGTH, '', FORM_FIELD_TRANSLIT | FORM_FIELD_REQUIRED);

			$this->form->select       ('visibility', $this->page->visibility, Lister\Visibility::range());

			$this->form->select       ('access', $this->page->access, Lister\Access::range());

			$this->form->input        ('description', $this->page->description, FORM_INPUT_TEXTAREA, CONFIG_PAGE_DESCRIPTION_MAX_LENGTH);

			$this->form->input        ('keywords', $this->page->keywords, FORM_INPUT_TEXTAREA, CONFIG_PAGE_KEYWORDS_MAX_LENGTH);

			$this->form->checkbox     ('robots_index', $this->page->robots_index);

			$this->form->checkbox     ('robots_follow', $this->page->robots_follow);

			$this->form->input        ('contents', $this->page->contents, FORM_INPUT_TEXTAREA);

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

			foreach ($fieldset as $name) $form->hidden($name);

			if (false === ($post = $form->post())) return false;

			# Create page

			$this->page = Entity\Factory::page($post['id']);

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
