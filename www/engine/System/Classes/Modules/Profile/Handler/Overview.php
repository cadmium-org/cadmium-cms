<?php

namespace System\Modules\Profile\Handler {

	use System\Modules\Auth, System\Utils\Lister, System\Utils\View, Date, Geo\Country, Geo\Timezone;

	class Overview {

		# Get contents

		private function getContents() {

            $contents = View::get('Blocks\Profile\Overview');

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

		public function handle() {

			return $this->getContents();
		}
	}
}
