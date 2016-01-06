<?php

namespace Utils {

	use Template, Url;

	abstract class Pagination {

		# Set items

		private static function setItems(Template\Asset\Block $pagination, int $active, int $count, Url $url) {

			$items = $pagination->loop('items');

			for ($index = ($active - 2); $index <= ($active + 2); $index++) {

				if (!($index > 0 && $index <= $count)) continue;

				$class = (($index === $active) ? 'active item' : 'item');

				$url->set('index', $index); $link = $url->get();

				$items->add(['class' => $class, 'link' => $link, 'index' => $index]);
			}
		}

		# Set first & last button

		private static function setExtremeButtons(Template\Asset\Block $pagination, int $active, int $count, Url $url) {

			$extremums = [1, $count]; $buttons = [];

			$buttons['first'] = [$extremums[0], ($active < ($extremums[0] + 4)), ($active < ($extremums[0] + 3))];
			$buttons['last']  = [$extremums[1], ($active > ($extremums[1] - 4)), ($active > ($extremums[1] - 3))];

			foreach ($buttons as $class => $data) {

				list ($index, $closest, $disabled) = $data; $block = $pagination->block($class);

				if ($disabled) { $block->disable(); continue; }

				$block->link = $url->set('index', $index)->get(); $block->index = $index;

				if ($closest) $block->block('ellipsis')->disable();
			}
		}

		# Set previous & next buttons

		private static function setStepButtons(Template\Asset\Block $pagination, int $active, int $count, Url $url) {

			$extremums = [1, $count]; $buttons = [];

			$buttons['prev'] = [$extremums[0], ($active - 1)];
			$buttons['next'] = [$extremums[1], ($active + 1)];

			foreach ($buttons as $class => $data) {

				list ($extremum, $index) = $data; $block = $pagination->block($class);

				if ($active === $extremum) { $block->disable(); $pagination->block($class . '_disabled')->enable(); }

				else $block->link = $url->set('index', $index)->get();
			}
		}

		# Get block

		public static function block(int $index, int $display, int $total, Url $url) {

			if (($index <= 0) || ($display <= 0) || ($total <= 0)) return false;

			if (($display >= $total) || ($index > ($count = ceil($total / $display)))) return false;

			# Create block

			$pagination = View::get('Blocks\Utils\Pagination');

			# Set items

			self::setItems($pagination, $index, $count, $url);

			# Set buttons

			self::setExtremeButtons($pagination, $index, $count, $url);

			self::setStepButtons($pagination, $index, $count, $url);

			# ------------------------

			return $pagination;
		}
	}
}
