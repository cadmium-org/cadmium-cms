<?php

namespace {

	abstract class Mailer {

		# Send mail

		public static function send(string $to, string $sender, string $from, string $reply_to,

			string $subject, string $message, bool $is_html = false) {

			# Set headers

			$headers  = ('MIME-Version: 1.0' . PHP_EOL);

			$headers .= ('Content-Type: ' . ($is_html ? 'text/html' : 'text/plain') . '; charset=UTF-8' . PHP_EOL);

			$headers .= ('From: ' . $sender . ' <' . $from . '>' . PHP_EOL);

			$headers .= ('Reply-To: ' . $sender . ' <' . $reply_to . '>' . PHP_EOL);

			$headers .= ('X-Mailer: PHP/' . phpversion() . PHP_EOL);

			# Send message

			return @mail($to, $subject, $message, $headers);
		}
	}
}
