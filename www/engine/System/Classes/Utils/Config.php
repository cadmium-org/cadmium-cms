<?php

namespace System\Utils {

	use Explorer, Geo\Timezone, Number, String, Validate;

	abstract class Config {

		private static $config = array (

			CONFIG_PARAM_ADMIN_LANGUAGE         => false,
			CONFIG_PARAM_ADMIN_TEMPLATE         => false,

			CONFIG_PARAM_SITE_LANGUAGE          => false,
			CONFIG_PARAM_SITE_TEMPLATE          => false,
			CONFIG_PARAM_SITE_TITLE             => false,
			CONFIG_PARAM_SITE_STATUS            => false,
			CONFIG_PARAM_SITE_DESCRIPTION       => false,
			CONFIG_PARAM_SITE_KEYWORDS          => false,

			CONFIG_PARAM_SYSTEM_URL             => false,
			CONFIG_PARAM_SYSTEM_TIMEZONE        => false,
			CONFIG_PARAM_SYSTEM_EMAIL           => false,

			CONFIG_PARAM_USERS_REGISTRATION     => false
		);

		# Init configuration

		public static function init() {

			$config_file = (DIR_SYSTEM_DATA . 'Config.json');

			if (false !== ($config = Explorer::json($config_file))) {

				foreach ($config as $name => $value) self::set($name, $value);
			}

			# Define constants

			foreach (self::$config as $name => $value) define(('CONFIG_' . strtoupper($name)), $value);

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

		# Set value

		public static function set($name, $value) {

			$name = strval($name);

			# Set admin language

			if ($name === CONFIG_PARAM_ADMIN_LANGUAGE) {

				return (false !== (self::$config[$name] = Extend\Languages::validate($value)));
			}

			# Set admin template

			if ($name === CONFIG_PARAM_ADMIN_TEMPLATE) {

				return (false !== (self::$config[$name] = Extend\Templates::validate($value)));
			}

			# Set site language

			if ($name === CONFIG_PARAM_SITE_LANGUAGE) {

				return (false !== (self::$config[$name] = Extend\Languages::validate($value)));
			}

			# Set site template

			if ($name === CONFIG_PARAM_SITE_TEMPLATE) {

				return (false !== (self::$config[$name] = Extend\Templates::validate($value)));
			}

			# Set site title

			if ($name === CONFIG_PARAM_SITE_TITLE) {

				return ('' !== (self::$config[$name] = strval($value)));
			}

			# Set site status

			if ($name === CONFIG_PARAM_SITE_STATUS) {

				return (null !== (self::$config[$name] = intabs($value)));
			}

			# Set site description

			if ($name === CONFIG_PARAM_SITE_DESCRIPTION) {

				return (null !== (self::$config[$name] = strval($value)));
			}

			# Set site keywords

			if ($name === CONFIG_PARAM_SITE_KEYWORDS) {

				return (null !== (self::$config[$name] = strval($value)));
			}

			# Set system url

			if ($name === CONFIG_PARAM_SYSTEM_URL) {

				return (false !== (self::$config[$name] = Validate::url($value)));
			}

			# Set system timezone

			if ($name === CONFIG_PARAM_SYSTEM_TIMEZONE) {

				return (false !== (self::$config[$name] = Timezone::validate($value)));
			}

			# Set system email

			if ($name === CONFIG_PARAM_SYSTEM_EMAIL) {

				return (false !== (self::$config[$name] = Validate::email($value)));
			}

			# Set users registration

			if ($name === CONFIG_PARAM_USERS_REGISTRATION) {

				return (null !== (self::$config[$name] = boolval($value)));
			}

			# ------------------------

			return false;
		}

		# Get value

		public static function get($name) {

			$name = strval($name);

			return (isset(self::$config[$name]) ? self::$config[$name] : false);
		}
	}
}
