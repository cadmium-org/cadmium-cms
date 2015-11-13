<?php

namespace System\Utils {

	use Arr, Template;

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

			if (null === $text) return Arr::get(self::$messages, ['info']);

			self::setMessage('info', $text, $header);
		}

		# Set warning message

		public static function warning(string $text = null, string $header = null) {

			if (null === $text) return Arr::get(self::$messages, ['warning']);

			self::setMessage('warning', $text, $header);
		}

		# Set error message

		public static function error(string $text = null, string $header = null) {

			if (null === $text) return Arr::get(self::$messages, ['error']);

			self::setMessage('error', $text, $header);
		}

		# Set success message

		public static function success(string $text = null, string $header = null) {

			if (null === $text) return Arr::get(self::$messages, ['success']);

			self::setMessage('success', $text, $header);
		}

		# Get block

		public static function block() {

			$messages = Template::group();

			foreach (self::$messages as $type => $message) {

				$messages->add($block = View::get('Blocks\Utils\Message'));

				$block->type = $type; $block->set('text', $message['text'], true); $header = $block->block('header');

				if (isset($message['header'])) $header->set('text', $message['header'], true); else $header->disable();
			}

			# ------------------------

			return $messages;
		}
	}
}
