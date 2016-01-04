<?php

namespace {

	abstract class Mailer {

		# Send mail

		public static function send(string $to, string $sender, string $from, string $reply_to,

			string $subject, string $message, bool $is_html = false) {

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
