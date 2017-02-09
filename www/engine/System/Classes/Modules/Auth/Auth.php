<?php

/**
 * @package Cadmium\System\Modules\Auth
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules {

	use DB, Session;

	abstract class Auth {

		private static $admin = false, $auth = null, $user = null;

		/**
		 * Initialize the session
		 *
		 * @property string $section : an active section (SECTION_SITE or SECTION_ADMIN)
		 *
		 * @return bool : true on success or false on failure
		 */

		public static function init(string $section) : bool {

			self::$admin = ($section === SECTION_ADMIN);

			self::$auth = null; self::$user = Entitizer::get(TABLE_USERS);

			# Check session code

			if (!is_string($code = Session::get('code'))) return false;

			# Authorize

			if (false === ($result = Auth\Utils\Connector\Session::authorize($code, self::$admin))) return false;

			# Update auth

			$result['auth']->edit(['time' => REQUEST_TIME]);

			# Update user

			$result['user']->edit(['time_logged' => REQUEST_TIME]);

			# Set entities

			self::$auth = $result['auth']; self::$user = $result['user'];

			# ------------------------

			return true;
		}

		/**
		 * Delete the session
		 *
		 * @return bool : true on success or false on failure
		 */

		public static function logout() : bool {

			if ((null === self::$user) || (0 === self::$user->id)) return false;

			# Remove auth entry from db

			self::$auth->remove();

			# Remove session variable

			Session::delete('code');

			# Reset entities

			self::$auth = null; self::$user = Entitizer::get(TABLE_USERS);

			# ------------------------

			return true;
		}

		/**
		 * Check whether the initial registration is required (the users table is empty and auto_increment is set to 0)
		 */

		public static function isInitial() : bool {

			DB::send("SHOW TABLE STATUS WHERE name LIKE '" . TABLE_USERS . "'");

			if (!(DB::getLast() && (null !== ($data = DB::getLast()->getRow())))) return false;

			# ------------------------

			return (($data['Rows'] == 0) && ($data['Auto_increment'] == 1));
		}

		/**
		 * Check whether the authorization mode is set to admin
		 */

		public static function isAdmin() : bool {

			return self::$admin;
		}

		/**
		 * Check whether the authorization was successful
		 */

		public static function isLogged() : bool {

			return ((null !== self::$user) && (0 !== self::$user->id));
		}

		/**
		 * Get the user param
		 *
		 * @return mixed|null : the param value or null if the session was not initialized
		 */

		public static function get(string $name) {

			return (self::$user->$name ?? null);
		}

		/**
		 * Return the user entity object
		 *
		 * @return Modules\Entitizer\Entity\User|false : the user entity object or false if the session was not initialized
		 */

		public static function getUser() {

			return (self::$user ?? false);
		}
	}
}
