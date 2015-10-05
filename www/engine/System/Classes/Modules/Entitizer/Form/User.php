<?php

namespace System\Modules\Entitizer\Form {

	use System\Modules\Auth, System\Modules\Entitizer, System\Utils\Form, System\Utils\Lister, Geo\Country, Geo\Timezone, Language;

	class User extends Form {

		# Constructor

		public function __construct(Entitizer\Controller\User $user) {

			parent::__construct('user');

			# Add fields

			$this->input('name', $user->name, FORM_INPUT_TEXT, CONFIG_USER_NAME_MAX_LENGTH, '', FORM_FIELD_REQUIRED);

			$this->input('email', $user->email, FORM_INPUT_TEXT, CONFIG_USER_EMAIL_MAX_LENGTH, '', FORM_FIELD_REQUIRED);

			$rank_disabled = ((($user->id === 1) || ($user->id === Auth::user()->id)) ? FORM_FIELD_DISABLED : 0);

			$this->select('rank', $user->rank, Lister\Rank::range(), null, $rank_disabled);

			$this->input('first_name', $user->first_name, FORM_INPUT_TEXT, CONFIG_USER_FIRST_NAME_MAX_LENGTH);

			$this->input('last_name', $user->last_name, FORM_INPUT_TEXT, CONFIG_USER_LAST_NAME_MAX_LENGTH);

			$this->select('sex', $user->sex, Lister\Sex::range());

			$this->input('city', $user->city, FORM_INPUT_TEXT, CONFIG_USER_CITY_MAX_LENGTH);

			$this->select('country', $user->country, Country::range(), '----', FORM_FIELD_SEARCH);

			$this->select('timezone', $user->timezone, Timezone::range(), null, FORM_FIELD_SEARCH);

			$this->input('password', '', FORM_INPUT_PASSWORD, CONFIG_USER_PASSWORD_MAX_LENGTH, '',

				((0 === $user->id) ? FORM_FIELD_REQUIRED : 0));

			$this->input('password_retype', '', FORM_INPUT_PASSWORD, CONFIG_USER_PASSWORD_MAX_LENGTH, '',

				((0 === $user->id) ? FORM_FIELD_REQUIRED : 0));
		}
	}
}
