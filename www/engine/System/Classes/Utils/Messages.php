<?php

namespace System\Utils {

	use Template;

	abstract class Messages {

		private static $messages = array('info' => null, 'warning' => null, 'error' => null, 'success' => null);

		# Set message

		private static function setMessage($type, $text, $header) {

			if (null !== self::$messages[$type]) return;

			$text = strval($text); $header = strval($header);

			self::$messages[$type] = array('text' => $text, 'header' => $header);
		}

		# Set info message

		public static function info($text = null, $header = null) {

			if (null === $text) return self::$messages['info'];

			self::setMessage('info', $text, $header);
		}

		# Set warning message

		public static function warning($text = null, $header = null) {

			if (null === $text) return self::$messages['warning'];

			self::setMessage('warning', $text, $header);
		}

		# Set error message

		public static function error($text = null, $header = null) {

			if (null === $text) return self::$messages['error'];

			self::setMessage('error', $text, $header);
		}

		# Set success message

		public static function success($text = null, $header = null) {

			if (null === $text) return self::$messages['success'];

			self::setMessage('success', $text, $header);
		}

		# Get block

		public static function block() {

			$messages = Template::group();

			foreach (self::$messages as $type => $message) {

				if (null === $message) continue;

				$messages->add($block = Template::block('Utils/Message'));

				$block->type = $type; $block->text = $message['text']; $header = $block->block('header');

				if ('' !== $message['header']) $header->text = $message['header']; else $header->disable();
			}

			# ------------------------

			return $messages;
		}
	}
}
