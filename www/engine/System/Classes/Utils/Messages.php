<?php

/**
 * @package Cadmium\System\Utils
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Utils {

	use Template;

	abstract class Messages {

		protected static $view = 'Blocks/Utils/Message';

		protected static $types = ['info', 'warning', 'error', 'success'];

		protected static $items = [];

		/**
		 * Initialize the messages list
		 */

		public static function init() {

			static::$items = [];
		}

		/**
		 * Set a message
		 */

		public static function set(string $type, string $text, string $title = null) {

			if (!in_array($type, static::$types, true) || isset(static::$items[$type]) || ('' === $text)) return;

			static::$items[$type] = ['text' => $text, 'title' => (('' !== $title) ? $title : null)];
		}

		/**
		 * Get a message
		 *
		 * @return array|false : the message data or false if the message was not set
		 */

		public static function get(string $type) {

			return (static::$items[$type] ?? false);
		}

		/**
		 * Get a messages block
		 */

		public static function getBlock() : Template\Block {

			$messages = Template::createBlock();

			foreach (static::$items as $type => $item) {

				$messages->addItem($message = View::get(static::$view));

				$message->type = $type; $message->text = Template::createBlock($item['text']);

				if (isset($item['title'])) $message->getBlock('title')->set('text', $item['title'])->enable();
			}

			# ------------------------

			return $messages;
		}
	}
}
