<?php

/**
 * @package Framework\Mailer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2016, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace {

	abstract class Mailer {

		/**
		 * Send an email
		 *
		 * @return true if the mail was successfully accepted for delivery, otherwise false
		 */

		public static function send(string $to, string $sender, string $from, string $reply_to,

			string $subject, string $message, bool $is_html = false) : bool {

			# Set headers

			$headers  = ('MIME-Version: 1.0' . "\r\n");

			$headers .= ('Content-Type: ' . ($is_html ? 'text/html' : 'text/plain') . '; charset=UTF-8' . "\r\n");

			$headers .= ('From: ' . $sender . ' <' . $from . '>' . "\r\n" . 'Reply-To: ' . $reply_to . "\r\n");

			$headers .= ('X-Mailer: PHP/' . phpversion() . "\r\n");

			# Send message

			return @mail($to, $subject, $message, $headers);
		}
	}
}
