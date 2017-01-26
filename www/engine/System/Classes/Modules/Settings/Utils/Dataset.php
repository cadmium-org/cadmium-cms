<?php

/**
 * @package Cadmium\System\Modules\Settings
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Settings\Utils {

	use Modules\Extend, Utils\Range, Utils\Validate, Geo\Timezone, Request;

	class Dataset extends \Dataset {

		/**
		 * Get default system url
		 */

		private function getSystemUrl() : string {

			if (empty($_SERVER['HTTP_HOST'])) return CONFIG_SYSTEM_URL;

			return ((Request::isSecure() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST']);
		}

		/**
		 * Get default system email
		 */

		private function getSystemEmail() : string {

			if (empty($_SERVER['HTTP_HOST'])) return CONFIG_SYSTEM_EMAIL;

			return ('admin@' . $_SERVER['HTTP_HOST']);
		}

		/**
		 * Constructor
		 */

		public function __construct() {

			# Site language

			$this->addParam('site_language', CONFIG_SITE_LANGUAGE, function (string $name) {

				return ((false !== ($name = Extend\Languages::validate($name))) ? $name : null);
			});

			# Site template

			$this->addParam('site_template', CONFIG_SITE_TEMPLATE, function (string $name) {

				return ((false !== ($name = Extend\Templates::validate($name))) ? $name : null);
			});

			# Site title

			$this->addParam('site_title', CONFIG_SITE_TITLE, function (string $title) {

				return (('' !== $title) ? $title : null);
			});

			# Site slogan

			$this->addParam('site_slogan', CONFIG_SITE_SLOGAN, function (string $slogan) {

				return $slogan;
			});

			# Site status

			$this->addParam('site_status', CONFIG_SITE_STATUS, function (int $status) {

				return ((false !== ($status = Range\Status::validate($status))) ? $status : null);
			});

			# Site description

			$this->addParam('site_description', CONFIG_SITE_DESCRIPTION, function (string $description) {

				return $description;
			});

			# Site keywords

			$this->addParam('site_keywords', CONFIG_SITE_KEYWORDS, function (string $keywords) {

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

			$this->addParam('system_timezone', CONFIG_SYSTEM_TIMEZONE, function (string $timezone) {

				return ((false !== ($timezone = Timezone::validate($timezone))) ? $timezone : null);
			});

			# Admin language

			$this->addParam('admin_language', CONFIG_ADMIN_LANGUAGE, function (string $name) {

				return ((false !== ($name = Extend\Languages::validate($name))) ? $name : null);
			});

			# Admin template

			$this->addParam('admin_template', CONFIG_ADMIN_TEMPLATE, function (string $name) {

				return ((false !== ($name = Extend\Templates::validate($name))) ? $name : null);
			});

			# Admin display entities

			$this->addParam('admin_display_entities', CONFIG_ADMIN_DISPLAY_ENTITIES, function (int $display) {

				return ((false !== ($display = Range\Display\Entities::validate($display))) ? $display : null);
			});

			# Admin display files

			$this->addParam('admin_display_files', CONFIG_ADMIN_DISPLAY_FILES, function (int $display) {

				return ((false !== ($display = Range\Display\Files::validate($display))) ? $display : null);
			});
		}
	}
}
