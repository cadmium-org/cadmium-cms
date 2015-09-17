<?php

namespace System\Handlers\Site\Profile {

	use System, System\Modules\Profile, Language;

	class Edit extends System\Frames\Site\Component\Profile {

		# Handle request

		protected function handle() {

			$this->title = Language::get('TITLE_PROFILE');

			$edit = new Profile\Handler\Edit();

			# ------------------------

			return $edit->handle();
		}
	}
}
