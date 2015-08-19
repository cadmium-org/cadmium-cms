<?php

namespace System\Handlers\Admin\System {

	use Error, System, System\Forms, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config;
	use System\Utils\Entitizer, System\Utils\Extend, System\Utils\Lister, System\Utils\Messages;
	use System\Utils\Pagination, System\Utils\Requirements, System\Utils\Utils, System\Utils\View;

	use Agent, Arr, Cookie, Date, DB, Explorer, Form, Geo\Country, Geo\Timezone;
	use Headers, Language, Mailer, Number, Request, Session, String, Tag, Template, Url, Validate;

	class Settings extends System\Frames\Admin\Component\System {

		private $form = null;

		# Save configuration

		private function setData($data) {

			foreach ($data as $name => $value) if (false === Config::set($name, $value)) {

				Messages::error(Language::get('SETTINGS_ERROR_PARAM'));
			}

			return ((null === Messages::error()) && (true === Config::save()));
		}

		# Get contents

		private function getContents() {

			$contents = View::get('Blocks/Contents/System/Settings');

			# Implement form

			$this->form->implement($contents);

			# ------------------------

			return $contents;
		}

		# Handle request

		protected function handle() {

			# Create form

			$this->form = new Forms\Admin\System\Settings();

			# Post form

			if (false !== ($post = $this->form->post())) {

				if (false === $this->setData($post)) Messages::error(Language::get('SETTINGS_ERROR_SAVE'));

				else Request::redirect('/admin/system/settings?submitted');

			} else if (null !== Request::get('submitted')) Messages::success(Language::get('SETTINGS_SUCCESS'));

			# Fill template

			$this->setTitle(Language::get('TITLE_SYSTEM_SETTINGS'));

			$this->setContents($this->getContents());

			# ------------------------

			return true;
		}
	}
}
