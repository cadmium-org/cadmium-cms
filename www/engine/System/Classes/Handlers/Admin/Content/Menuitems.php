<?php

namespace System\Handlers\Admin\Content {

	use Error, Warning, System, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config, System\Utils\Entity;
	use System\Utils\Extend, System\Utils\Lister, System\Utils\Messages, System\Utils\Pagination;
	use System\Utils\Requirements, System\Utils\Utils;

	use Agent, Arr, Cookie, Date, DB, Explorer, Form, Geo\Country, Geo\Timezone;
	use Headers, Language, Mailer, Number, Request, Session, String, Tag, Template, Url, Validate;

	class Menuitems extends System\Frames\Admin\Listview\Menuitems {

		private $menuitem = false, $form = false;

		# Get path

		private function getPath() {

			$path = $this->menuitem->path(); $count = count($path);

			foreach (array_keys($path) as $key) {

				$path[$key]['class'] = (($key === ($count - 1)) ? 'active section' : 'section');
			}

			return $path;
		}

		# Get contents

		private function getContents() {

			$contents = Template::block('Contents/Content/Menuitems/Main');

			# Set general

			$contents->id = $this->menuitem->id();

			$contents->parent_id = $this->menuitem->parentId();

			# Set path

			$contents->path = ($path = $this->getPath());

			# Set parent text

			$parent_text = (($this->menuitem->parentId() !== 0) ? $path[count($path) - 2]['text'] : ('- ' . Language::get('NONE')));

			$contents->block('parent')->text = $parent_text;

			# Set form

			foreach ($this->form->fields() as $name => $block) $contents->block(('field_' . $name), $block);

			# ------------------------

			return $contents;
		}

		# Handle request

		protected function handle() {

			# Create menuitem

			$this->menuitem = new Entity\Menuitem();

			if ((null !== ($id = Request::get('id'))) && (false === $this->menuitem->init($id))) {

				Messages::error(Language::get('MENUITEMS_ITEM_NOT_FOUND'));
			}

			if (false === $this->menuitem->id()) return $this->handleList();

			# Create form

			$this->form = new Form('menuitem'); $fieldset = $this->form->fieldset();

			# Add form fields

			$fieldset->hidden		('parent_id', $this->menuitem->parentId());

			$fieldset->text			('text', $this->menuitem->text(), CONFIG_MENUITEM_TEXT_MAX_LENGTH);

			$fieldset->text			('link', $this->menuitem->link(), CONFIG_MENUITEM_LINK_MAX_LENGTH);

			$fieldset->select		('target', $this->menuitem->target(), Lister::target());

			$fieldset->text			('position', $this->menuitem->position(), CONFIG_MENUITEM_POSITION_MAX_LENGTH);

			# Post form

			if (false !== ($post = $this->form->post())) {

				if (true !== ($result = $this->menuitem->edit($post))) Messages::error(Language::get($result));

				else Request::redirect('/admin/content/menuitems?id=' . $this->menuitem->id() . '&submitted');

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

			foreach ($fieldset as $name) $form->fieldset()->virtual($name);

			if (false === ($post = $form->post())) return false;

			# Create menuitem

			$this->menuitem = new Entity\Menuitem(); $this->menuitem->init($post['id']);

			# Process list

			if ($post['action'] == 'list') return $this->handleListAjax($this->menuitem->id());

			# Process remove

			if ($post['action'] == 'remove') {

				if (false === $this->menuitem->id()) return Ajax::error(Language::get('MENUITEMS_ITEM_NOT_FOUND'));

				return $this->menuitem->remove();
			}

			# ------------------------

			return false;
		}
	}
}

?>
