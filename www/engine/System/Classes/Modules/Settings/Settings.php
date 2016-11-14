<?php

namespace Modules {

	use Utils\Schema, Number;

	abstract class Settings {

		private static $settings = null, $loaded = false;

		# Autoloader

		public static function __autoload() {

			if (null === self::$settings) self::$settings = new Settings\Utils\Dataset;
		}

		# Load settings

		public static function load() {

			if (null === ($data = Schema::get('Settings')->load())) return false;

			self::$settings->setArray($data); self::$loaded = true;

			# ------------------------

			return true;
		}

		# Save settings

		public static function save() {

			return Schema::get('Settings')->save(self::$settings->getData());
		}

		# Set value

		public static function set(string $name, $value) {

			return self::$settings->set($name, $value);
		}

		# Set multiple values

		public static function setArray(array $data) {

			return self::$settings->setArray($data);
		}

		# Get value

		public static function get(string $name) {

			return self::$settings->get($name);
		}

		# Get data

		public static function getData() {

			return self::$settings->getData();
		}

		# Check if settings are loaded

		public static function loaded() {

			return self::$loaded;
		}
	}
}
