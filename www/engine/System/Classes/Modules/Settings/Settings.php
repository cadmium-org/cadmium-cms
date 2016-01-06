<?php

namespace Modules {

	use Utils\Lister, Explorer, Geo\Timezone, Validate;

	abstract class Settings {

		private static $loaded = false;

		# Params

		private static $settings = [

			'admin_language'        => CONFIG_ADMIN_LANGUAGE_DEFAULT,
			'admin_template'        => CONFIG_ADMIN_TEMPLATE_DEFAULT,

			'site_language'         => CONFIG_SITE_LANGUAGE_DEFAULT,
			'site_template'         => CONFIG_SITE_TEMPLATE_DEFAULT,

			'site_title'            => CONFIG_SITE_TITLE_DEFAULT,
			'site_slogan'           => CONFIG_SITE_SLOGAN_DEFAULT,

			'site_status'           => STATUS_ONLINE,

			'site_description'      => '',
			'site_keywords'         => '',

			'system_url'            => CONFIG_SYSTEM_URL_DEFAULT,
			'system_email'          => CONFIG_SYSTEM_EMAIL_DEFAULT,
			'system_timezone'       => CONFIG_SYSTEM_TIMEZONE_DEFAULT,

			'users_registration'    => false
		];

		# Init settings

		public static function init() {

			$settings_file = (DIR_SYSTEM_DATA . 'Settings.json');

			self::$loaded = (false !== ($settings = Explorer::json($settings_file)));

			if (self::$loaded) foreach ($settings as $name => $value) self::set($name, $value);

			# ------------------------

			return true;
		}

		# Save settings

		public static function save() {

			$settings_file = (DIR_SYSTEM_DATA . 'Settings.json');

			if (false === ($settings = json_encode(self::$settings, JSON_PRETTY_PRINT))) return false;

			if (false === Explorer::save($settings_file, $settings, true)) return false;

			# ------------------------

			return true;
		}

		# Check if settings file is loaded

		public static function loaded() {

			return self::$loaded;
		}

		# Set value

		public static function set(string $name, $value) {

			if (!isset(self::$settings[$name])) return false;

			# Validate language

			if (($name === 'admin_language') || ($name === 'site_language')) {

				if (false === ($value = Extend\Languages::validate($value))) return false;
			}

			# Validate template

			else if (($name === 'admin_template') || ($name === 'site_template')) {

				if (false === ($value = Extend\Templates::validate($value))) return false;
			}

			# Validate site title

			else if ($name === 'site_title') {

				if ('' === ($value = (function(string $value) { return $value; })($value))) return false;
			}

			# Validate site status

			else if ($name === 'site_status') {

				if (false === ($value = Lister\Status::validate($value))) return false;
			}

			# Validate site slogan/description/keywords

			else if (($name === 'site_slogan') || ($name === 'site_description') || ($name === 'site_keywords')) {

				$value = (function(string $value) { return $value; })($value);
			}

			# Validate system url

			else if ($name === 'system_url') {

				if (false === ($value = Validate::url($value))) return false;
			}

			# Validate system email

			else if ($name === 'system_email') {

				if (false === ($value = Validate::email($value))) return false;
			}

			# Validate system timezone

			else if ($name === 'system_timezone') {

				if (false === ($value = Timezone::validate($value))) return false;
			}

			# Validate users registration

			else if ($name === 'users_registration') {

				$value = (function(bool $value) { return $value; })($value);
			}

			# Set value

			self::$settings[$name] = $value;

			# ------------------------

			return true;
		}

		# Get value

		public static function get(string $name = null) {

			if (null === $name) return self::$settings;

			return (isset(self::$settings[$name]) ? self::$settings[$name] : null);
		}
	}
}
