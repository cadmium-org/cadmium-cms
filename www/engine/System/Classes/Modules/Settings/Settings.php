<?php

namespace Modules {

	use Utils\Lister, Utils\Validate, Explorer, Geo\Timezone, Request;

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

			'system_url'            => '',
			'system_email'          => '',
			'system_timezone'       => CONFIG_SYSTEM_TIMEZONE_DEFAULT,

			'users_registration'    => false
		];

		# Autoloader

		public static function __autoload() {

			if (self::$loaded || empty($host = getenv('HTTP_HOST'))) return;

			self::$settings['system_url'] = ((Request::isSecure() ? 'https://' : 'http://') . $host);

			self::$settings['system_email'] = ('admin@' . $host);
		}

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

			if (!isset(self::$settings[$name]) || !is_scalar($value)) return false;

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

				if ('' === ($value = strval($value))) return false;
			}

			# Validate site status

			else if ($name === 'site_status') {

				if (false === ($value = Lister\Status::validate($value))) return false;
			}

			# Validate site slogan/description/keywords

			else if (($name === 'site_slogan') || ($name === 'site_description') || ($name === 'site_keywords')) {

				$value = strval($value);
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

				$value = boolval($value);
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
