<?php

namespace Modules\Profile\Handler {

	use Frames, Modules\Auth, Utils\Range, Utils\View, Date, Geo\Country;

	class Overview extends Frames\Site\Area\Authorized {

		protected $title = 'TITLE_PROFILE';

		# Get contents

		private function getContents() {

			$contents = View::get('Blocks/Profile/Overview');

			# Set general

			$contents->name = Auth::user()->name;

			$contents->email = Auth::user()->email;

			$contents->rank = (Range\Rank::get(Auth::user()->rank) ?? '');

			$contents->time = Date::get(DATE_FORMAT_DATETIME, Auth::user()->time_registered);

			# Set sex

			$contents->sex = (Range\Sex::get(Auth::user()->sex) ?? '');

			# Set full name & city

			foreach (['full_name', 'city'] as $name) {

				if ('' === ($text = Auth::user()->$name)) $contents->getBlock($name)->disable();

				else $contents->getBlock($name)->text = $text;
			}

			# Set country

			if ('' === ($country = Auth::user()->country)) $contents->getBlock('country')->disable(); else {

				$contents->getBlock('country')->code = $country;

				$contents->getBlock('country')->name = (Country::get($country) ?? '');
			}

			# ------------------------

			return $contents;
		}

		# Handle request

		protected function handle() {

			return $this->getContents();
		}
	}
}
