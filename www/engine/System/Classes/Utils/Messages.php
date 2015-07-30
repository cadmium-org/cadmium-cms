<?php

namespace System\Utils {

	use String, Template;

	abstract class Messages {

		private static $messages = array('info' => false, 'warning' => false, 'error' => false, 'success' => false);

		# Set message

		private static function setMessage($type, $text, $header) {

			if (false !== self::$messages[$type]) return;

			if (false === ($text = String::validate($text))) return;

			$header = String::validate($header);

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

				if (false === $message) continue;

				$messages->add($block = Template::block('Utils/Message'));

				$block->type = $type; $block->text = $message['text']; $header = $block->block('header');

				if (false === $message['header']) $header->disable(); else $header->text = $message['header'];
			}

			# ------------------------

			return $messages;
		}
	}
}
