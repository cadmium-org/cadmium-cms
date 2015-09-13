<?php

namespace System\Modules {

	use System\Utils\Lister, Explorer, Geo\Timezone, String, Validate;

	abstract class Config {

		private static $loaded = false;

		private static $config = [

			'admin_language'        => CONFIG_ADMIN_LANGUAGE_DEFAULT,
			'admin_template'        => CONFIG_ADMIN_TEMPLATE_DEFAULT,

			'site_language'         => CONFIG_SITE_LANGUAGE_DEFAULT,
			'site_template'         => CONFIG_SITE_TEMPLATE_DEFAULT,

			'site_title'            => CONFIG_SITE_TITLE_DEFAULT,

			'site_status'           => STATUS_ONLINE,

			'site_description'      => '',
			'site_keywords'         => '',

			'system_url'            => CONFIG_SYSTEM_URL_DEFAULT,
			'system_email'          => CONFIG_SYSTEM_EMAIL_DEFAULT,
			'system_timezone'       => CONFIG_SYSTEM_TIMEZONE_DEFAULT,

			'users_registration'    => false
		];

		# Init configuration

		public static function init() {

			$config_file = (DIR_SYSTEM_DATA . 'Config.json');

			self::$loaded = (false !== ($config = Explorer::json($config_file)));

			if (self::$loaded) foreach ($config as $name => $value) self::set($name, $value);

			# ------------------------

			return true;
		}

		# Save configuration

		public static function save() {

			$config_file = (DIR_SYSTEM_DATA . 'Config.json');

			if (false === ($config = json_encode(self::$config, JSON_PRETTY_PRINT))) return false;

			if (false === Explorer::save($config_file, $config, true)) return false;

			# ------------------------

			return true;
		}

		# Check if configuration file is loaded

		public static function loaded() {

			return self::$loaded;
		}

		# Set value

		public static function set($name, $value) {

			$name = strval($name);

			if (!isset(self::$config[$name])) return false;

			# Validate admin language

			if (($name === 'admin_language') || ($name === 'site_language')) {

				if (false === ($value = Extend\Languages::validate($value))) return false;
			}

			# Validate admin template

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

			# Validate site description

			else if (($name === 'site_description') || ($name === 'site_keywords')) {

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

			# Validate value

			self::$config[$name] = $value;

			# ------------------------

			return true;
		}

		# Get value

		public static function get($name) {

			$name = strval($name);

			return (isset(self::$config[$name]) ? self::$config[$name] : null);
		}
	}
}
