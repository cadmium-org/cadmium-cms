<?php

namespace System\Utils {

	use Template, Url;

	abstract class Pagination {

		# Get block

		public static function block($index, $display, $total, $url) {

			$pagination = Template::block('Utils/Pagination');

			$index = intabs($index); $display = intabs($display); $total = intabs($total);

			$url = (($url instanceof Url) ? $url : new Url());

			if ((0 === $display) || (0 === $total) || ($total <= $display)) return false;

			if ($index > ($count = intval(ceil($total / $display)))) return false;

			$items = array();

			for ($i = ($index - 3); $i <= ($index + 3); $i++) {

				$item = clone $url; $item->set('index', $i);

				$class = ($i === $index ? 'active item' : 'item'); $link = $item->get();

				if ($i > 0 && $i <= $count) $items[] = array('class' => $class, 'link' => $link, 'index' => $i);
			}

			# Set prev

			if ($index === 1) { $pagination->block('prev')->disable(); $pagination->block('prev_disabled')->enable(); }

			else { $prev = clone $url; $prev->set('index', ($index - 1)); $pagination->block('prev')->link = $prev->get(); }

			# Set first

			if ($index < 5) $pagination->block('first')->disable(); else {

				$first = clone $url; $first->set('index', 1);

				$pagination->block('first')->link = $first->get(); $pagination->block('first')->index = 1;

				if ($index === 5) $pagination->block('first')->block('ellipsis')->disable();
			}

			# Set items

			$pagination->items = $items;

			# Set last

			if ($index > ($count - 4)) $pagination->block('last')->disable(); else {

				if ($index === ($count - 4)) $pagination->block('last')->block('ellipsis')->disable();

				$last = clone $url; $last->set('index', $count);

				$pagination->block('last')->link = $last->get(); $pagination->block('last')->index = $count;
			}

			# Set next

			if ($index === $count) { $pagination->block('next')->disable(); $pagination->block('next_disabled')->enable(); }

			else { $next = clone $url; $next->set('index', ($index + 1)); $pagination->block('next')->link = $next->get(); }

			# ------------------------

			return $pagination;
		}
	}
}
