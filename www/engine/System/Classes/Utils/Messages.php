<?php

namespace Utils {

	use Template;

	abstract class Messages {

		protected static $types = ['info', 'warning', 'error', 'success'];

		protected static $items = [];

		# Init messages

		public static function init() {

			static::$items = [];
		}

		# Set message

		public static function set(string $type, string $text, string $title = null) {

			if (!in_array($type, static::$types, true) || isset(static::$items[$type]) || ('' === $text)) return;

			static::$items[$type] = ['text' => $text, 'title' => (('' !== $title) ? $title : null)];
		}

		# Get message

		public static function get(string $type) {

			return (static::$items[$type] ?? false);
		}

		# Get block

		public static function block() {

			$messages = Template::group();

			foreach (static::$items as $type => $item) {

				$messages->add($block = View::get('Blocks\Utils\Message'));

				$block->type = $type; $block->text = Template::block($item['text']);

				if (isset($item['title'])) $block->block('title')->set('text', $item['title'])->enable();
			}

			# ------------------------

			return $messages;
		}
	}
}
