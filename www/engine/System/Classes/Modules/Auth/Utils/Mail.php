<?php

namespace Modules\Auth\Utils {

	use Modules\Auth, Modules\Entitizer, Modules\Settings, Utils\View, Date, Language, Mailer;

	abstract class Mail {

		# Send mail

		private static function send(Entitizer\Entity\User $user, string $view, string $subject, string $link) {

			$message = View::get($view);

			$message->name = $user->name; $message->link = $link; $message->copyright = Date::year();

			# ------------------------

			$to = $user->email; $sender = Settings::get('site_title'); $reply_to = Settings::get('system_email');

			$from = ((false !== ($host = parse_url(Settings::get('system_url'), PHP_URL_HOST))) ? ('noreply@' . $host) : '');

			return Mailer::send($to, $sender, $from, $reply_to, $subject, $message->contents(), true);
		}

		# Send reset mail

		public static function reset(Entitizer\Entity\User $user, string $code) {

			$link = (Settings::get('system_url') . (Auth::admin() ? '/admin' : '/profile') . '/recover?code=' . $code);

			return self::send($user, 'Blocks\Auth\Mail\Reset', Language::get('MAIL_SUBJECT_RESET'), $link);
		}

		# Send register mail

		public static function register(Entitizer\Entity\User $user) {

			$link = (Settings::get('system_url') . (Auth::admin() ? '/admin' : '/profile'));

			return self::send($user, 'Blocks\Auth\Mail\Register', Language::get('MAIL_SUBJECT_REGISTER'), $link);
		}
	}
}
