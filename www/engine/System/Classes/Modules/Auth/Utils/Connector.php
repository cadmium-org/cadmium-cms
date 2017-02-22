<?php

/**
 * @package Cadmium\System\Modules\Auth
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Auth\Utils {

	use Modules\Entitizer, Utils\Validate;

	abstract class Connector {

		# Connector configuration interface

		protected static $type = '', $lifetime = '';

		/**
		 * Authorize with a given session/secret code and an authorization mode
		 *
		 * @return array|false : the array of type ['auth' => $auth, 'user' => $user],
		 *         where $auth is an object of type Entitizer\Entity\User\Session or Entitizer\Entity\User\Secret,
		 *         and $user is an object of type Entitizer\Entity\User, or false on failure
		 */

		public static function authorize(string $code, bool $admin) {

			# Check code

			if (false === ($code = Validate::authCode($code))) return false;

			# Get auth

			if (!($auth = Entitizer::get(static::$type))->init($code, 'code')) return false;

			if (($auth->ip !== REQUEST_CLIENT_IP) || ($auth->time < (REQUEST_TIME - static::$lifetime))) return false;

			# Get user

			if (0 === ($user = Entitizer::get(TABLE_USERS, $auth->id))->id) return false;

			if ($user->rank < ($admin ? RANK_ADMINISTRATOR : RANK_USER)) return false;

			# ------------------------

			return ['auth' => $auth, 'user' => $user];
		}
	}
}
