<?php

/**
 * @package Cadmium\System\Modules\Profile
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Profile\Handler {

	use Frames, Modules\Auth, Utils\Range, Utils\View, Date, Geo\Country, Template;

	class Overview extends Frames\Site\Area\Authorized {

		protected $_title = 'TITLE_PROFILE';

		/**
		 * Get the contents block
		 */

		private function getContents() : Template\Block {

			$contents = View::get('Blocks/Profile/Overview');

			# Set general

			$contents->name = Auth::get('name');

			$contents->email = Auth::get('email');

			$contents->rank = (Range\Rank::get(Auth::get('rank')) ?? '');

			$contents->time = Date::get(DATE_FORMAT_DATETIME, Auth::get('time_registered'));

			# Set sex

			$contents->sex = (Range\Sex::get(Auth::get('sex')) ?? '');

			# Set full name & city

			foreach (['full_name', 'city'] as $name) {

				if ('' === ($text = Auth::get($name))) $contents->getBlock($name)->disable();

				else $contents->getBlock($name)->text = $text;
			}

			# Set country

			if ('' === ($country = Auth::get('country'))) $contents->getBlock('country')->disable(); else {

				$contents->getBlock('country')->code = $country;

				$contents->getBlock('country')->name = (Country::get($country) ?? '');
			}

			# ------------------------

			return $contents;
		}

		/**
		 * Handle the request
		 */

		protected function handle() : Template\Block {

			return $this->getContents();
		}
	}
}
