<?php

namespace Modules\Profile\Form {

	use Modules\Auth, Utils\Form, Utils\Range, Geo\Country, Geo\Timezone, Language;

	class Personal extends Form {

		protected $name = 'edit';

		# Constructor

		public function __construct() {

			$this->addText('email', Auth::get('email'), FORM_FIELD_TEXT, CONFIG_USER_EMAIL_MAX_LENGTH, ['required' => true]);

			$this->addText('first_name', Auth::get('first_name'), FORM_FIELD_TEXT, CONFIG_USER_FIRST_NAME_MAX_LENGTH);

			$this->addText('last_name', Auth::get('last_name'), FORM_FIELD_TEXT, CONFIG_USER_LAST_NAME_MAX_LENGTH);

			$this->addSelect('sex', Auth::get('sex'), Range\Sex::getRange());

			$this->addText('city', Auth::get('city'), FORM_FIELD_TEXT, CONFIG_USER_CITY_MAX_LENGTH);

			$this->addSelect('country', Auth::get('country'), Country::getRange(), Language::get('COUNTRY_NOT_SELECTED'), ['search' => true]);

			$this->addSelect('timezone', Auth::get('timezone'), Timezone::getRange(), null, ['search' => true]);
		}
	}
}
