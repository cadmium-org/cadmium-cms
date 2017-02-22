<?php

/**
 * @package Cadmium\System\Modules\Auth
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Auth\Utils {

	use Modules\Auth, Modules\Entitizer, Modules\Settings, Utils\View, Date, Language, Mailer;

	abstract class Mail {

		/**
		 * Send a message
		 */

		private static function send(Entitizer\Entity\User $user, string $view, string $subject, string $link) : bool {

			$message = View::get((Auth::isAdmin() ? 'Blocks/Auth/Mail/' : 'Blocks/Profile/Auth/Mail/') . $view);

			$message->name = $user->name; $message->link = $link; $message->copyright = Date::getYear();

			$to = $user->email; $sender = Settings::get('site_title'); $reply_to = Settings::get('system_email');

			$from = ((false !== ($host = parse_url(Settings::get('system_url'), PHP_URL_HOST))) ? ('noreply@' . $host) : '');

			# ------------------------

			return Mailer::send($to, $sender, $from, $reply_to, $subject, $message->getContents(), true);
		}

		/**
		 * Send the password reset message containing a secret code to a given user
		 */

		public static function sendPasswordMessage(Entitizer\Entity\User $user, string $code) : bool {

			$link = (Settings::get('system_url') . (Auth::isAdmin() ? '/admin' : '/profile') . '/recover?code=' . $code);

			return self::send($user, 'Reset', Language::get('MAIL_SUBJECT_RESET'), $link);
		}

		/**
		 * Send the registration message to a given user
		 */

		public static function sendRegistrationMessage(Entitizer\Entity\User $user) : bool {

			$link = (Settings::get('system_url') . (Auth::isAdmin() ? '/admin' : '/profile'));

			return self::send($user, 'Register', Language::get('MAIL_SUBJECT_REGISTER'), $link);
		}
	}
}
