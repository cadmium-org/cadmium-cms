<?php

namespace System\Utils\Auth\Controller {

	use System\Utils\Auth, DB, String;

	abstract class Login {

		# Errors

		const ERROR_NAME_INVALID                    = 'USER_ERROR_NAME_INVALID';
		const ERROR_NAME_INCORRECT                  = 'USER_ERROR_NAME_INCORRECT';
		const ERROR_PASSWORD_INVALID                = 'USER_ERROR_PASSWORD_INVALID';
		const ERROR_PASSWORD_INCORRECT              = 'USER_ERROR_PASSWORD_INCORRECT';

		const ERROR_ACCESS                          = 'USER_ERROR_ACCESS';

		# Process login operation

		public static function process($post) {

			# Declare variables

			$name = null; $password = null;

			# Extract post array

			extract($post);

			# Validate values

			if (false === ($name = Auth::user()->validateName($name))) return self::ERROR_NAME_INVALID;

			if (false === ($password = Auth::user()->validatePassword($password))) return self::ERROR_PASSWORD_INVALID;

			# Select user from DB

			if (!Auth::user()->initByUnique('name', $name)) return self::ERROR_NAME_INCORRECT;

			if (Auth::admin() && (Auth::user()->rank < RANK_ADMINISTRATOR)) return self::ERROR_NAME_INCORRECT;

			# Check password

			$password = String::encode(Auth::user()->auth_key, $password);

			if (0 !== strcmp(Auth::user()->password, $password)) return self::ERROR_PASSWORD_INCORRECT;

			# Check access

			if (!Auth::admin() && (Auth::user()->rank === RANK_GUEST)) return self::ERROR_ACCESS;

			# ------------------------

			return true;
		}
	}
}
