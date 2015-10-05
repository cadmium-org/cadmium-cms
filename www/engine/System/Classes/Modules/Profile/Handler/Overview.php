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

			# Set sex

			$contents->block('sex')->text = Lister\Sex::get(Auth::user()->sex);

			# Set full name & city

			foreach (['full_name', 'city'] as $name) {

				if ('' === ($text = Auth::user()->$name)) $contents->block($name)->disable();

				else $contents->block($name)->text = $text;
			}

			# Set country

			if ('' === ($country = Auth::user()->country)) $contents->block('country')->disable(); else {

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
