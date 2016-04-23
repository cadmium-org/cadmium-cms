<?php

namespace Utils {

	use Template;

	abstract class Popup extends Messages {

		protected static $types = ['positive', 'negative'];

		protected static $items = [];

		# Get block

		public static function block() {

			$popup = Template::group(); $icons = ['positive' => 'checkmark', 'negative' => 'warning'];

			foreach (static::$items as $type => $item) {

				$popup->add($block = View::get('Blocks\Utils\Popup'));

				$block->type = $type; $block->text = Template::block($item['text']);

				$block->title = ($item['title'] ?? null); $block->icon = $icons[$type];
			}

			# ------------------------

			return $popup;
		}
	}
}
