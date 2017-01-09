<?php

/**
 * @package Cadmium\System\Modules\Settings
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules {

	use Utils\Schema;

	abstract class Settings {

		private static $settings = null, $loaded = false;

		/**
		 * Autoloader
		 */

		public static function __autoload() {

			if (null === self::$settings) self::$settings = new Settings\Utils\Dataset;
		}

		/**
		 * Load settings from the file
		 *
		 * @return bool : true on success or false on error
		 */

		public static function load() : bool {

			if (null === ($data = Schema::get('Settings')->load())) return false;

			self::$settings->setArray($data); self::$loaded = true;

			# ------------------------

			return true;
		}

		/**
		 * Save settings to the file
		 *
		 * @return bool : true on success or false on error
		 */

		public static function save() : bool {

			return Schema::get('Settings')->save(self::$settings->getData());
		}

		/**
		 * Set a param value
		 *
		 * @return bool|null : true on success, false on error, or null if the param does not exist
		 */

		public static function set(string $name, $value) {

			return self::$settings->set($name, $value);
		}

		/**
		 * Set multiple values
		 *
		 * @return array : the array of set results for every param (true on success or false on error)
		 */

		public static function setArray(array $data) : array {

			return self::$settings->setArray($data);
		}

		/**
		 * Get a param value
		 *
		 * @return mixed|null : the value or null if the param does not exist
		 */

		public static function get(string $name) {

			return self::$settings->get($name);
		}

		/**
		 * Get the array of params and their values
		 */

		public static function getData() : array {

			return self::$settings->getData();
		}

		/**
		 * Get the array of params and their default values
		 */

		public static function getDefaults() : array {

			return self::$settings->getDefaults();
		}

		/**
		 * Check whether settings are loaded
		 */

		public static function areLoaded() : bool {

			return self::$loaded;
		}
	}
}
