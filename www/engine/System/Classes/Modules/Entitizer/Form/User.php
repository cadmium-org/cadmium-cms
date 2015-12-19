<?php

namespace System\Modules\Entitizer\Form {

	use System\Modules\Auth, System\Modules\Entitizer, System\Utils\Form, System\Utils\Lister, Geo\Country, Geo\Timezone, Language;

	class User extends Form {

		# Constructor

		public function __construct(Entitizer\Entity\User $user) {

			parent::__construct(ENTITY_TYPE_USER);

			# Add fields

			$this->input('name', $user->name, FORM_INPUT_TEXT, CONFIG_USER_NAME_MAX_LENGTH, ['required' => true]);

			$this->input('email', $user->email, FORM_INPUT_TEXT, CONFIG_USER_EMAIL_MAX_LENGTH, ['required' => true]);

			$rank_disabled = (($user->id === 1) || ($user->id === Auth::user()->id));

			$this->select('rank', $user->rank, Lister\Rank::list(), null, ['disabled' => $rank_disabled]);

			$this->input('first_name', $user->first_name, FORM_INPUT_TEXT, CONFIG_USER_FIRST_NAME_MAX_LENGTH);

			$this->input('last_name', $user->last_name, FORM_INPUT_TEXT, CONFIG_USER_LAST_NAME_MAX_LENGTH);

			$this->select('sex', $user->sex, Lister\Sex::list());

			$this->input('city', $user->city, FORM_INPUT_TEXT, CONFIG_USER_CITY_MAX_LENGTH);

			$this->select('country', $user->country, Country::list(), Language::get('COUNTRY_NOT_SELECTED'), ['search' => true]);

			$this->select('timezone', $user->timezone, Timezone::list(), null, ['search' => true]);

			$this->input('password', '', FORM_INPUT_PASSWORD, CONFIG_USER_PASSWORD_MAX_LENGTH, ['required' => (0 === $user->id)]);

			$this->input('password_retype', '', FORM_INPUT_PASSWORD, CONFIG_USER_PASSWORD_MAX_LENGTH, ['required' => (0 === $user->id)]);
		}
	}
}
