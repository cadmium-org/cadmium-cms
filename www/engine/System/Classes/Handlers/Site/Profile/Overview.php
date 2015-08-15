<?php

namespace System\Handlers\Site\Profile {

	use Error, System, System\Forms, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config;
	use System\Utils\Entity, System\Utils\Extend, System\Utils\Lister, System\Utils\Messages;
	use System\Utils\Pagination, System\Utils\Requirements, System\Utils\Utils, System\Utils\View;

	use Agent, Arr, Cookie, Date, DB, Explorer, Form, Geo\Country, Geo\Timezone;
	use Headers, Language, Mailer, Number, Request, Session, String, Tag, Template, Url, Validate;

	class Overview extends System\Frames\Site\Component\Profile {

		# Get contents

		private function getContents() {

			$contents = View::get('Blocks/Contents/Profile/Overview');

			# Set general

			$contents->name = Auth::user()->name;

			$contents->email = Auth::user()->email;

			$contents->rank = Lister\Rank::get(Auth::user()->rank);

			$contents->time = Date::get(DATE_FORMAT_DATETIME, Auth::user()->time_registered);

			# Set full name

			if (!($full_name = Auth::user()->full_name)) $contents->block('full_name')->disable();

			else $contents->block('full_name')->text = $full_name;

			# Set sex

			if (!($sex = Auth::user()->sex)) $contents->block('sex')->disable();

			else $contents->block('sex')->text = Lister\Sex::get($sex);

			# Set city

			if (!($city = Auth::user()->city)) $contents->block('city')->disable();

			else $contents->block('city')->text = $city;

			# Set country

			if (!($country = Auth::user()->country)) $contents->block('country')->disable(); else {

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
