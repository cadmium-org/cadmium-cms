<?php

namespace System\Handlers\Admin\Content {

	use Error, System, System\Forms, System\Views, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config;
	use System\Utils\Entity, System\Utils\Extend, System\Utils\Lister, System\Utils\Messages;
	use System\Utils\Pagination, System\Utils\Requirements, System\Utils\Utils;

	use Agent, Arr, Cookie, Date, DB, Explorer, Form, Geo\Country, Geo\Timezone;
	use Headers, Language, Mailer, Number, Request, Session, String, Tag, Template, Url, Validate;

	class Menuitems extends System\Frames\Admin\Listview\Menuitems {

		private $menuitem = null, $form = null;

		# Get path

		private function getPath() {

			$path = $this->menuitem->path; $count = count($path);

			foreach (array_keys($path) as $key) {

				$path[$key]['class'] = (($key === ($count - 1)) ? 'active section' : 'section');
			}

			return $path;
		}

		# Get contents

		private function getContents() {

			$contents = Template::block('Contents/Content/Menuitems/Main');

			# Set general

			$contents->id = $this->menuitem->id;

			$contents->parent_id = $this->menuitem->parent_id;

			# Set path

			$contents->path = ($path = $this->getPath());

			# Set parent text

			$parent_text = (($this->menuitem->parent_id !== 0) ? $path[count($path) - 2]['text'] : ('- ' . Language::get('NONE')));

			$contents->block('parent')->text = $parent_text;

			# Set form

			$this->form->implement($contents);

			# ------------------------

			return $contents;
		}

		# Handle request

		protected function handle() {

			if (null === ($id = Request::get('id'))) return $this->handleList();

			# Create menuitem

			$this->menuitem = new Entity\Type\Menuitem\Manager($id);

			if (0 === $this->menuitem->id) return $this->handleList(true);

			# Create form

			$this->form = new Form('menuitem');

			# Add form fields

			$this->form->input        ('parent_id', $this->menuitem->parent_id, FORM_INPUT_HIDDEN);

			$this->form->input        ('text', $this->menuitem->text, FORM_INPUT_TEXT, CONFIG_MENUITEM_TEXT_MAX_LENGTH, '', FORM_FIELD_REQUIRED);

			$this->form->input        ('link', $this->menuitem->link, FORM_INPUT_TEXT, CONFIG_MENUITEM_LINK_MAX_LENGTH, '');

			$this->form->select       ('target', $this->menuitem->target, Lister\Target::range());

			$this->form->input        ('position', $this->menuitem->position, FORM_INPUT_TEXT, CONFIG_MENUITEM_POSITION_MAX_LENGTH);

			# Post form

			if (false !== ($post = $this->form->post())) {

				if ($this->form->errors()) Messages::error(Language::get('FORM_ERROR_REQUIRED'));

				else if (true !== ($result = $this->menuitem->edit($post))) Messages::error(Language::get($result));

				else Request::redirect('/admin/content/menuitems?id=' . $this->menuitem->id . '&submitted');

			} else if (null !== ($submitted = Request::get('submitted'))) {

				if ($submitted === 'create') Messages::success(Language::get('MENUITEM_SUCCESS_CREATE'));

				else Messages::success(Language::get('MENUITEM_SUCCESS_SAVE'));
			}

			# Fill template

			$this->setTitle(Language::get('TITLE_CONTENT_MENUITEMS_EDIT'));

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

			# Create menuitem

			$this->menuitem = Entity\Factory::menuitem($post['id']);

			# Process list

			if ($post['action'] == 'list') return $this->handleListAjax($this->menuitem->id);

			# Process remove

			if ($post['action'] == 'remove') {

				if (0 === $this->menuitem->id) return Ajax::error(Language::get('MENUITEMS_ITEM_NOT_FOUND'));

				return $this->menuitem->remove();
			}

			# ------------------------

			return false;
		}
	}
}
