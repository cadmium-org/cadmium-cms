<?php

namespace System\Modules\Auth\Utils {

	use System\Modules\Auth, System\Modules\Config, System\Utils\View, Date, Language, Mailer;

	abstract class Mail {

		# Send mail

		private static function send($view, $subject, $link) {

			$message = new View::get($view);

			$message->site_title = Config::get('site_title');

			$message->system_url = Config::get('system_url');

			$message->name = Auth::user()->name; $message->link = $link;

			$message->system_email = Config::get('system_email'); $message->copyright = Date::year();

			# ------------------------

			$to = Auth::user()->email; $sender = Config::get('site_title'); $reply_to = Config::get('system_email');

			$from = ((false !== ($host = parse_url(Config::get('system_url'), PHP_URL_HOST))) ? ('noreply@' . $host) : '');

			return Mailer::send($to, $sender, $from, $reply_to, $subject, $message->contents(true), true);
		}

		# Send reset mail

		public static function reset($code) {

			$link = (Config::get('system_url') . (Auth::admin() ? '/admin/recover?code=' : '/profile/recover?code=') . $code);

			return self::send('Auth\Mailing\Reset', Language::get('MAIL_SUBJECT_RESET'), $link);
		}

		# Send register mail

		public static function register() {

			$link = (Config::get('system_url') . (Auth::admin() ? '/admin' : '/profile'));

			return self::send('Auth\Mailing\Register', Language::get('MAIL_SUBJECT_REGISTER'), $link);
		}
	}
}
