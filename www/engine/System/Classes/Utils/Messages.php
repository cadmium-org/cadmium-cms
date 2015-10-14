<?php

namespace System\Utils {

	use Arr, Template;

	abstract class Messages {

		private static $messages = [];

		# Set message

		private static function setMessage($type, $text, $header) {

			if (isset(self::$messages[$type])) return;

			$text = strval($text); $header = strval($header);

			self::$messages[$type] = ['text' => $text, 'header' => $header];
		}

		# Init messages

		public static function init() {

			self::$messages = [];
		}

		# Set info message

		public static function info($text = null, $header = null) {

			if (null === $text) return Arr::get(self::$messages, ['info']);

			self::setMessage('info', $text, $header);
		}

		# Set warning message

		public static function warning($text = null, $header = null) {

			if (null === $text) return Arr::get(self::$messages, ['warning']);

			self::setMessage('warning', $text, $header);
		}

		# Set error message

		public static function error($text = null, $header = null) {

			if (null === $text) return Arr::get(self::$messages, ['error']);

			self::setMessage('error', $text, $header);
		}

		# Set success message

		public static function success($text = null, $header = null) {

			if (null === $text) return Arr::get(self::$messages, ['success']);

			self::setMessage('success', $text, $header);
		}

		# Get block

		public static function block() {

			$messages = Template::group();

			foreach (self::$messages as $type => $message) {

				$messages->add($block = View::get('Blocks\Utils\Message'));

				$block->type = $type; $block->set('text', $message['text'], true); $header = $block->block('header');

				if ('' !== $message['header']) $header->set('text', $message['header'], true); else $header->disable();
			}

			# ------------------------

			return $messages;
		}
	}
}
