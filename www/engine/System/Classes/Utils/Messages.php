<?php

namespace Utils {

	use Template;

	abstract class Messages {

		private static $messages = [];

		# Set message

		private static function setMessage(string $type, string $text, string $header = null) {

			if (('' === $text) || isset(self::$messages[$type])) return;

			self::$messages[$type] = ['text' => $text, 'header' => null];

			if ((null !== $header) && ('' !== $header)) self::$messages[$type]['header'] = $header;
		}

		# Init messages

		public static function init() {

			self::$messages = [];
		}

		# Set info message

		public static function info(string $text = null, string $header = null) {

			if (null === $text) return (self::$messages['info'] ?? false);

			self::setMessage('info', $text, $header);
		}

		# Set warning message

		public static function warning(string $text = null, string $header = null) {

			if (null === $text) return (self::$messages['warning'] ?? false);

			self::setMessage('warning', $text, $header);
		}

		# Set error message

		public static function error(string $text = null, string $header = null) {

			if (null === $text) return (self::$messages['error'] ?? false);

			self::setMessage('error', $text, $header);
		}

		# Set success message

		public static function success(string $text = null, string $header = null) {

			if (null === $text) return (self::$messages['success'] ?? false);

			self::setMessage('success', $text, $header);
		}

		# Get block

		public static function block() {

			$messages = Template::group();

			foreach (self::$messages as $type => $message) {

				$messages->add($block = View::get('Blocks\Utils\Message'));

				$block->type = $type; $block->text = Template::block($message['text']); $header = $block->block('header');

				if (isset($message['header'])) $header->text = $message['header']; else $header->disable();
			}

			# ------------------------

			return $messages;
		}
	}
}
