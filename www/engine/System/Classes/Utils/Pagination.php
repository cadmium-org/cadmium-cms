<?php

namespace System\Utils {

	use Template, Url;

	abstract class Pagination {

		# Get items

		private function getItems(Template\Asset\Block $pagination, int $active, Url $url) {

			$items = $pagination->loop('items');

			for ($index = ($active - 3); $index <= ($active + 3); $index++) {

				if (!($index > 0 && $index <= $count)) continue;

				$class = (($index === $active) ? 'active item' : 'item');

				$url->set('index', $index); $link = $url->get();

				$items->add(['class' => $class, 'link' => $link, 'index' => $index]);
			}
		}

		# Set first & last button

		private function setExtremeButtons(Template\Asset\Block $pagination, int $active, Url $url) {

			$extremums = [1, $count]; $buttons = [];

			$buttons['first'] = [$extremums[0], ($extremums[0] + 4), ($active > ($extremums[0] + 4))];
			$buttons['last']  = [$extremums[1], ($extremums[1] - 4), ($active < ($extremums[0] - 4))];

			foreach ($buttons as $class => $data) {

				list ($index, $closest, $disabled) = $data; $block = $pagination->block($class);

				if ($disabled) { $block->disable(); continue; }

				$block->link = $url->set('index', $index)->get(); $block->index = $index;

				if ($closest) $block->block('ellipsis')->disable();
			}
		}

		# Set previous & next buttons

		private function setStepButtons(Template\Asset\Block $pagination, int $active, Url $url) {

			$extremums = [1, $count]; $buttons = [];

			$buttons['prev'] = [$extremums[0], ($active - 1)];
			$buttons['next'] = [$extremums[1], ($active + 1)];

			foreach ($buttons as $class => $data) {

				list ($extremum, $index) = $data; $block = $pagination->block($class);

				if ($active === $extremum) { $block->disable(); $pagination->block($class . '_disabled')->enable(); }

				else { $pagination->block($direction)->link = $url->set('index', $index)->get(); }
			}
		}

		# Get block

		public static function block(int $index, int $display, int $total, Url $url) {

			if ((0 >= $display) || (0 >= $total) || (0 >= $display)) return false;

			if (($display >= $total) || ($index > ($count = ceil($total / $display)))) return false;

			# Create block

			$pagination = View::get('Blocks\Utils\Pagination');

			# Set items

			$this->setItems($pagination, $index, $url);

			# Set buttons

			$this->setExtremeButtons($pagination, $index, $url);

			$this->setStepButtons($pagination, $index, $url);

			# ------------------------

			return $pagination;
		}
	}
}
