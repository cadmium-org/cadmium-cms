<?php

namespace Modules\Entitizer\Form {

	use Modules\Auth, Modules\Entitizer, Utils\Form, Utils\Range, Geo\Country, Geo\Timezone, Language;

	class User extends Form {

		# Constructor

		public function __construct(Entitizer\Entity\User $user) {

			parent::__construct('user');

			# Add fields

			$this->addText('name', $user->name, FORM_FIELD_TEXT, CONFIG_USER_NAME_MAX_LENGTH, ['required' => true]);

			$this->addText('email', $user->email, FORM_FIELD_TEXT, CONFIG_USER_EMAIL_MAX_LENGTH, ['required' => true]);

			$this->addSelect('rank', ((0 !== $user->id) ? $user->rank : RANK_USER), Range\Rank::array(), null,

				['disabled' => (($user->id === 1) || ($user->id === Auth::user()->id))]);

			$this->addText('first_name', $user->first_name, FORM_FIELD_TEXT, CONFIG_USER_FIRST_NAME_MAX_LENGTH);

			$this->addText('last_name', $user->last_name, FORM_FIELD_TEXT, CONFIG_USER_LAST_NAME_MAX_LENGTH);

			$this->addSelect('sex', $user->sex, Range\Sex::array());

			$this->addText('city', $user->city, FORM_FIELD_TEXT, CONFIG_USER_CITY_MAX_LENGTH);

			$this->addSelect('country', $user->country, Country::array(), Language::get('COUNTRY_NOT_SELECTED'), ['search' => true]);

			$this->addSelect('timezone', $user->timezone, Timezone::array(), null, ['search' => true]);

			$this->addText('password', '', FORM_FIELD_PASSWORD, CONFIG_USER_PASSWORD_MAX_LENGTH, ['required' => (0 === $user->id)]);

			$this->addText('password_retype', '', FORM_FIELD_PASSWORD, CONFIG_USER_PASSWORD_MAX_LENGTH, ['required' => (0 === $user->id)]);
		}
	}
}
