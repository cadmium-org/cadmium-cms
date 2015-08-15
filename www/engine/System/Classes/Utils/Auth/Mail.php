<?php

namespace System\Utils\Auth {

	use Date, Language, Mailer;

	abstract class Mail {

		# Send mail

		private static function send($view, $subject, $link) {

			$view = ('System\\Utils\\Auth\\View\\' . $view);

			$message = new $view();

			$message->site_title = CONFIG_SITE_TITLE; $message->system_url = CONFIG_SYSTEM_URL;

			$message->name = Auth::user()->name; $message->link = $link;

			$message->system_email = CONFIG_SYSTEM_EMAIL; $message->copyright = Date::year();

			# ------------------------

			$to = Auth::user()->email; $sender = CONFIG_SITE_TITLE; $reply_to = CONFIG_SYSTEM_EMAIL;

			$from = ((false !== ($host = parse_url(CONFIG_SYSTEM_URL, PHP_URL_HOST))) ? ('noreply@' . $host) : false);

			return Mailer::send($to, $sender, $from, $reply_to, $subject, $message->contents(true), true);
		}

		# Send reset mail

		public static function sendReset($code) {

			$link = (CONFIG_SYSTEM_URL . (Auth::admin() ? '/admin/recover?code=' : '/profile/recover?code=') . $code);

			return self::send('Reset', Language::get('MAIL_SUBJECT_RESET'), $link);
		}

		# Send register mail

		public static function sendRegister() {

			$link = (CONFIG_SYSTEM_URL . (Auth::admin() ? '/admin' : '/profile'));

			return self::send('Register', Language::get('MAIL_SUBJECT_REGISTER'), $link);
		}
	}
}
