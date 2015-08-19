<?php

namespace System\Forms\Site\Profile\Edit {

	use System\Utils\Auth, System\Utils\Lister, Form, Geo\Country, Geo\Timezone, Language;

	class Personal extends Form {

        # Constructor

        public function __construct() {

            parent::__construct('edit');

            # Add fields

            $this->input('email', Auth::user()->email, FORM_INPUT_TEXT, CONFIG_USER_EMAIL_MAX_LENGTH, '', FORM_FIELD_REQUIRED);

			$this->input('first_name', Auth::user()->first_name, FORM_INPUT_TEXT, CONFIG_USER_FIRST_NAME_MAX_LENGTH);

			$this->input('last_name', Auth::user()->last_name, FORM_INPUT_TEXT, CONFIG_USER_LAST_NAME_MAX_LENGTH);

			$this->select('sex', Auth::user()->sex, Lister\Sex::range());

			$this->input('city', Auth::user()->city, FORM_INPUT_TEXT, CONFIG_USER_CITY_MAX_LENGTH);

			$this->select('country', Auth::user()->country, Country::range(), Language::get('SELECT_COUNTRY'), FORM_FIELD_SEARCH);

			$this->select('timezone', Auth::user()->timezone, Timezone::range(), Language::get('SELECT_TIMEZONE'), FORM_FIELD_SEARCH);
        }
    }
}
