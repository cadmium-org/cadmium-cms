<?php

namespace System\Forms\Admin\System {

	use System\Utils\Auth, System\Utils\Entitizer, System\Utils\Lister, Form, Geo\Country, Geo\Timezone, Language;

	class Users extends Form {

        # Constructor

        public function __construct(Entitizer\Type\User\Manager $user, $create = false) {

            parent::__construct('user');

            $create = boolval($create);

            # Add fields

            $this->input('name', $user->name, FORM_INPUT_TEXT, CONFIG_USER_NAME_MAX_LENGTH, '', FORM_FIELD_REQUIRED);

			$this->input('email', $user->email, FORM_INPUT_TEXT, CONFIG_USER_EMAIL_MAX_LENGTH, '', FORM_FIELD_REQUIRED);

            $rank_disabled = ((($user->id === 1) || ($user->id === Auth::user()->id)) ? FORM_FIELD_DISABLED : 0);

			$this->select('rank', $user->rank, Lister\Rank::range(), '', $rank_disabled);

			$this->input('first_name', $user->first_name, FORM_INPUT_TEXT, CONFIG_USER_FIRST_NAME_MAX_LENGTH);

			$this->input('last_name', $user->last_name, FORM_INPUT_TEXT, CONFIG_USER_LAST_NAME_MAX_LENGTH);

			$this->select('sex', $user->sex, Lister\Sex::range());

			$this->input('city', $user->city, FORM_INPUT_TEXT, CONFIG_USER_CITY_MAX_LENGTH);

			$this->select('country', $user->country, Country::range(), Language::get('SELECT_COUNTRY'), FORM_FIELD_SEARCH);

			$this->select('timezone', $user->timezone, Timezone::range(), Language::get('SELECT_TIMEZONE'), FORM_FIELD_SEARCH);

			$this->input('password', '', FORM_INPUT_PASSWORD, CONFIG_USER_PASSWORD_MAX_LENGTH, '', ($create ? FORM_FIELD_REQUIRED : 0));

			$this->input('password_retype', '', FORM_INPUT_PASSWORD, CONFIG_USER_PASSWORD_MAX_LENGTH, '', ($create ? FORM_FIELD_REQUIRED : 0));
        }
    }
}
