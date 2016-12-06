<?php

namespace Modules\Settings\Utils {

	use Modules\Extend, Utils\Range, Utils\Validate, Geo\Timezone, Request;

	class Dataset extends \Dataset {

		# Get system url

		private function getSystemUrl() {

			if (!empty($_SERVER['HTTP_HOST'])) return ((Request::isSecure() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST']);
		}

		# Get system email

		private function getSystemEmail() {

			if (!empty($_SERVER['HTTP_HOST'])) return ('admin@' . $_SERVER['HTTP_HOST']);
		}

		# Constructor

		public function __construct() {

			# Admin language

			$this->addParam('admin_language', CONFIG_ADMIN_LANGUAGE_DEFAULT, function (string $name) {

				return ((false !== ($name = Extend\Languages::validate($name))) ? $name : null);
			});

			# Admin template

			$this->addParam('admin_template', CONFIG_ADMIN_TEMPLATE_DEFAULT, function (string $name) {

				return ((false !== ($name = Extend\Templates::validate($name))) ? $name : null);
			});

			# Site language

			$this->addParam('site_language', CONFIG_SITE_LANGUAGE_DEFAULT, function (string $name) {

				return ((false !== ($name = Extend\Languages::validate($name))) ? $name : null);
			});

			# Site template

			$this->addParam('site_template', CONFIG_SITE_TEMPLATE_DEFAULT, function (string $name) {

				return ((false !== ($name = Extend\Templates::validate($name))) ? $name : null);
			});

			# Site title

			$this->addParam('site_title', CONFIG_SITE_TITLE_DEFAULT, function (string $title) {

				return (('' !== $title) ? $title : null);
			});

			# Site slogan

			$this->addParam('site_slogan', CONFIG_SITE_SLOGAN_DEFAULT, function (string $slogan) {

				return $slogan;
			});

			# Site status

			$this->addParam('site_status', STATUS_ONLINE, function (string $status) {

				return ((false !== ($status = Range\Status::validate($status))) ? $status : null);
			});

			# Site description

			$this->addParam('site_description', '', function (string $description) {

				return $description;
			});

			# Site keywords

			$this->addParam('site_keywords', '', function (string $keywords) {

				return $keywords;
			});

			# System url

			$this->addParam('system_url', $this->getSystemUrl(), function (string $url) {

				return ((false !== ($url = Validate::url($url))) ? $url : null);
			});

			# System email

			$this->addParam('system_email', $this->getSystemEmail(), function (string $email) {

				return ((false !== ($email = Validate::email($email))) ? $email : null);
			});

			# System timezone

			$this->addParam('system_timezone', CONFIG_SYSTEM_TIMEZONE_DEFAULT, function (string $timezone) {

				return ((false !== ($timezone = Timezone::validate($timezone))) ? $timezone : null);
			});
		}
	}
}
