<?php

namespace System\Handlers\Admin\System {

	use Error, System, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config, System\Utils\Entity;
	use System\Utils\Extend, System\Utils\Lister, System\Utils\Messages, System\Utils\Pagination;
	use System\Utils\Requirements, System\Utils\Utils;

	use Agent, Arr, Cookie, Date, DB, Explorer, Form, Geo\Country, Geo\Timezone;
	use Headers, Language, Mailer, Number, Request, Session, String, Tag, Template, Url, Validate;

	class Users extends System\Frames\Admin\Listview\Users {

		private $create = false, $user = null, $form = null;

		# Get contents

		private function getContents() {

			$contents = Template::block('Contents/System/Users/Main');

			# Set general

			$contents->link = ('/admin/system/users?' . ($this->create ? 'create' : ('id=' . $this->user->id)));

			$contents->title = ($this->create ? Language::get('USERS_ITEM_NEW') : $this->user->name);

			# Set form

			foreach ($this->form->fields() as $name => $block) $contents->block(('field_' . $name), $block);

			# Set info

			if ($this->create) $contents->block('info')->disable(); else {

				$contents->block('info')->time_registered = Date::get(DATE_FORMAT_DATETIME, $this->user->time_registered);

				$contents->block('info')->time_logged = Date::get(DATE_FORMAT_DATETIME,$this->user->time_logged);
			}

			# ------------------------

			return $contents;
		}

		# Handle request

		protected function handle() {

			# Create user

			if (!($this->create = (null !== Request::get('create')))) {

				if (null === ($id = Request::get('id'))) return $this->handleList();

				$this->user = new Entity\Type\User\Manager($id);

				if (0 === $this->user->id) return $this->handleList(true);

			} else $this->user = Entity\Factory::user();

			# Create form

			$this->form = new Form('user'); $fieldset = $this->form->fieldset();

			# Add form fields

			$fieldset->text         ('name', $this->user->name, CONFIG_USER_NAME_MAX_LENGTH, '', FORM_FIELD_REQUIRED);

			$fieldset->text         ('email', $this->user->email, CONFIG_USER_EMAIL_MAX_LENGTH, '', FORM_FIELD_REQUIRED);

			$fieldset->select       ('rank', $this->user->rank, Lister\Rank::range(), '',

			                        ((($this->user->id === 1) || ($this->user->id === Auth::user()->id)) ? FORM_FIELD_DISABLED : 0));

			$fieldset->text         ('first_name', $this->user->first_name, CONFIG_USER_FIRST_NAME_MAX_LENGTH);

			$fieldset->text         ('last_name', $this->user->last_name, CONFIG_USER_LAST_NAME_MAX_LENGTH);

			$fieldset->select       ('sex', $this->user->sex, Lister\Sex::range());

			$fieldset->text         ('city', $this->user->city, CONFIG_USER_CITY_MAX_LENGTH);

			$fieldset->select       ('country', $this->user->country, Country::range(), Language::get('SELECT_COUNTRY'), FORM_FIELD_SEARCH);

			$fieldset->select       ('timezone', $this->user->timezone, Timezone::range(), Language::get('SELECT_TIMEZONE'), FORM_FIELD_SEARCH);

			$fieldset->password     ('password', '', CONFIG_USER_PASSWORD_MAX_LENGTH, '',

			                        ($this->create ? FORM_FIELD_REQUIRED : 0));

			$fieldset->password     ('password_retype', '', CONFIG_USER_PASSWORD_MAX_LENGTH, '',

			                        ($this->create ? FORM_FIELD_REQUIRED : 0));

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

		public function handleAjax() {

			# Process form

			$form = new Form('ajax'); $fieldset = array('action', 'id');

			foreach ($fieldset as $name) $form->fieldset()->virtual($name);

			if (false === ($post = $form->post())) return false;

			# Create user

			$this->user = Entity\Factory::user($post['id']);

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
