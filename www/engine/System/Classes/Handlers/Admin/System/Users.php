<?php

namespace System\Handlers\Admin\System {

	use Error, System, System\Forms, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config;
	use System\Utils\Entitizer, System\Utils\Extend, System\Utils\Lister, System\Utils\Messages;
	use System\Utils\Pagination, System\Utils\Requirements, System\Utils\Utils, System\Utils\View;

	use Agent, Arr, Cookie, Date, DB, Explorer, Form, Geo\Country, Geo\Timezone;
	use Headers, Language, Mailer, Number, Request, Session, String, Tag, Template, Url, Validate;

	class Users extends System\Frames\Admin\Listview\Users {

		private $create = false, $user = null, $form = null;

		# Get contents

		private function getContents() {

			$contents = View::get('Blocks/Contents/System/Users/Main');

			# Set general

			$contents->link = ('/admin/system/users?' . ($this->create ? 'create' : ('id=' . $this->user->id)));

			$contents->title = ($this->create ? Language::get('USERS_ITEM_NEW') : $this->user->name);

			# Implement form

			$this->form->implement($contents);

			# Set info

			if ($this->create) $contents->block('info')->disable(); else {

				$contents->block('info')->time_registered = Date::get(DATE_FORMAT_DATETIME, $this->user->time_registered);

				$contents->block('info')->time_logged = Date::get(DATE_FORMAT_DATETIME,$this->user->time_logged);
			}

			# ------------------------

			return $contents;
		}

		# Handle request

		protected function handle($ajax = false) {

			if ($ajax) return $this->handleAjax();

			# Create user

			if (!($this->create = (null !== Request::get('create')))) {

				if (null === ($id = Request::get('id'))) return $this->handleList();

				$this->user = Entitizer::manager(ENTITY_TYPE_USER, $id);;

				if (0 === $this->user->id) return $this->handleList(true);

			} else $this->user = Entitizer::manager(ENTITY_TYPE_USER, 0);

			# Create form

			$this->form = new Forms\Admin\System\Users($this->user, $this->create);

			# Post form

			if (false !== ($post = $this->form->post())) {

				if ($this->form->errors()) Messages::error(Language::get('FORM_ERROR_REQUIRED')); else {

					$result = ($this->create ? $this->user->create($post) : $this->user->edit($post));

					if (true !== $result) Messages::error(Language::get($result));

					else Request::redirect('/admin/system/users?id=' . $this->user->id . '&submitted');
				}

			} else if (null !== Request::get('submitted')) Messages::success(Language::get('USER_SUCCESS_SAVE'));

			# Fill template

			$this->setTitle(Language::get($this->create ? 'TITLE_SYSTEM_USERS_CREATE' : 'TITLE_SYSTEM_USERS_EDIT'));

			$this->setContents($this->getContents());

			# ------------------------

			return true;
		}

		# Handle ajax request

		protected function handleAjax() {

			# Process form

			$form = new Form('ajax'); $fieldset = array('action', 'id');

			foreach ($fieldset as $name) $form->virtual($name);

			if (false === ($post = $form->post())) return false;

			# Create user

			$this->user = Entitizer::user($post['id']);

			# Process remove

			if ($post['action'] == 'remove') {

				if (0 === $this->user->id) return Ajax::error(Language::get('USERS_ITEM_NOT_FOUND'));

				return $this->user->remove();
			}

			# ------------------------

			return false;
		}
	}
}
