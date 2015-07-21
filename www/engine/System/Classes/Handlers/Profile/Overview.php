<?php

namespace System\Handlers\Profile {

	use Error, Warning, System, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config, System\Utils\Entity;
	use System\Utils\Extend, System\Utils\Lister, System\Utils\Messages, System\Utils\Pagination;
	use System\Utils\Requirements, System\Utils\Utils;

	use Agent, Arr, Cookie, Date, DB, Explorer, Form, Geo\Country, Geo\Timezone;
	use Headers, Language, Mailer, Number, Request, Session, String, Tag, Template, Url, Validate;

	class Overview extends System\Frames\Site\Handler {

		# Get contents

		private function getContents() {

			$contents = Template::block('Contents/Profile/Overview');

			# Set general

			$contents->name = Auth::user()->name();

			$contents->email = Auth::user()->email();

			$contents->rank = Lister::rank(Auth::user()->rank());

			$contents->time = Date::get(DATE_FORMAT_DATETIME, Auth::user()->timeRegistered());

			# Set full name

			if (false == ($full_name = Auth::user()->fullName())) $contents->block('full_name')->disable();

			else $contents->block('full_name')->text = $full_name;

			# Set sex

			if (false == ($sex = Auth::user()->sex())) $contents->block('sex')->disable();

			else $contents->block('sex')->text = Lister::sex($sex);

			# Set city

			if (false == ($city = Auth::user()->city())) $contents->block('city')->disable();

			else $contents->block('city')->text = $city;

			# Set country

			if (false == ($country = Auth::user()->country())) $contents->block('country')->disable(); else {

				$contents->block('country')->code = $country;

				$contents->block('country')->name = Country::get($country);
			}

			# ------------------------

			return $contents;
		}

		# Handle request

		protected function handle() {

			# Fill template

			$this->setTitle(Language::get('TITLE_PROFILE'));

			$this->setContents($this->getContents());

			# ------------------------

			return true;
		}
	}
}

?>
