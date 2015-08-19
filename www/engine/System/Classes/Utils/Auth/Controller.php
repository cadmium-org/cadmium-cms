<?php

namespace System\Utils\Auth {

	use System\Utils\Entitizer, System\Utils\Auth, Session, String;

	abstract class Controller {

		# Errors

		const ERROR_AUTH_LOGIN                      = 'USER_ERROR_AUTH_LOGIN';
		const ERROR_AUTH_RESET                      = 'USER_ERROR_AUTH_RESET';
		const ERROR_AUTH_RECOVER                    = 'USER_ERROR_AUTH_RECOVER';
		const ERROR_AUTH_REGISTER                   = 'USER_ERROR_AUTH_REGISTER';

		# Insert session/secret code

		private static function insertCode($type, $code) {

			$extension = Entitizer::create($type, Auth::user()->id);

			$extension->remove();

			$data = array('code' => $code, 'ip' => ENGINE_CLIENT_IP, 'time' => ENGINE_TIME);

			return $extension->create($data);
		}

		# Remove session/secret code

		private static function removeCode($type) {

			$extension = Entitizer::create($type, Auth::user()->id);

			return $extension->remove();
		}

		# Create new session

		public static function login($post) {

			if (0 !== Auth::user()->id) return true;

			# Process post data

			if (true !== ($result = Controller\Login::process($post))) return $result;

			# Create session

			if (!self::insertCode(ENTITY_TYPE_USER_SESSION, ($code = String::random(40)))) return self::ERROR_AUTH_LOGIN;

			# Set session variable

			Session::set(USER_SESSION_PARAM_CODE, $code);

			# ------------------------

			return true;
		}

		# Create new secret

		public static function reset($post) {

			if (0 !== Auth::user()->id) return true;

			# Process post data

			if (true !== ($result = Controller\Reset::process($post))) return $result;

			# Create secret

			if (!self::insertCode(ENTITY_TYPE_USER_SECRET, ($code = String::random(40)))) return self::ERROR_AUTH_RESET;

			# Send mail

			Mail::sendReset($code);

			# ------------------------

			return true;
		}

		# Recover password

		public static function recover($post) {

			if (0 === Auth::user()->id) return false;

			# Process post data

			if (true !== ($result = Controller\Recover::process($post))) return $result;

			else if (false === $result) return self::ERROR_AUTH_RECOVER;

			# Remove secret

			self::removeCode(ENTITY_TYPE_USER_SECRET);

			# ------------------------

			return true;
		}

		# Register new user

		public static function register($post) {

			if (0 !== Auth::user()->id) return true;

			# Process post data

			if (true !== ($result = Controller\Register::process($post))) return $result;

			else if (false === $result) return self::ERROR_AUTH_REGISTER;

			# Send mail

			Mail::sendRegister();

			# ------------------------

			return true;
		}

		# Delete session

		public static function logout() {

			if (0 === Auth::user()->id) return false;

			# Remove session

			self::removeCode(ENTITY_TYPE_USER_SESSION);

			# Remove session variable

			Session::delete(USER_SESSION_PARAM_CODE);

			# ------------------------

			return true;
		}
	}
}
