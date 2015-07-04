<?php

namespace {

	abstract class Mailer {

		# Send message

		public static function send($to, $sender, $from, $reply_to, $subject, $message, $is_html = false) {

			$to = String::validate($to); $sender = String::validate($sender);

			$from = String::validate($from); $reply_to = String::validate($reply_to);

			$subject = String::validate($subject); $message = String::validate($message); $is_html = Validate::boolean($is_html);

			# Set headers

			$headers  = ('MIME-Version: 1.0' . "\r\n");

			$headers .= ('Content-Type: ' . ($is_html ? 'text/html' : 'text/plain') . '; charset=' . CONFIG_FRAMEWORK_DEFAULT_CHARSET . "\r\n");

			$headers .= ('From: ' . $sender . ' <' . $from . '>' . "\r\n") .

			$headers .= ('Reply-To: ' . $sender . ' <' . $reply_to . '>' . "\r\n");

			$headers .= ('X-Mailer: PHP/' . phpversion() . "\r\n");

			# Send mail

			return @mail($to, $subject, $message, $headers);
		}
	}
}

?>
