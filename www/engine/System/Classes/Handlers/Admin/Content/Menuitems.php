<?php

namespace System\Handlers\Admin\Content {

	use Error, System, System\Forms, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config;
	use System\Utils\Entitizer, System\Utils\Extend, System\Utils\Lister, System\Utils\Messages;
	use System\Utils\Pagination, System\Utils\Requirements, System\Utils\Utils, System\Utils\View;

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

			$contents = View::get('Blocks/Contents/Content/Menuitems/Main');

			# Set general

			$contents->id = $this->menuitem->id;

			$contents->parent_id = $this->menuitem->parent_id;

			# Set path

			$contents->path = ($path = $this->getPath());

			# Set parent text

			$parent_text = (($this->menuitem->parent_id !== 0) ? $path[count($path) - 2]['text'] : ('- ' . Language::get('NONE')));

			$contents->block('parent')->text = $parent_text;

			# Implement form

			$this->form->implement($contents);

			# ------------------------

			return $contents;
		}

		# Handle request

		protected function handle() {

			if (null === ($id = Request::get('id'))) return $this->handleList();

			# Create menuitem

			$this->menuitem = Entitizer::manager(ENTITY_TYPE_MENUITEM, $id);

			if (0 === $this->menuitem->id) return $this->handleList(true);

			# Create form

			$this->form = new Forms\Admin\Content\Menuitems\Edit($this->menuitem);

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

			$this->menuitem = Entitizer::menuitem($post['id']);

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
