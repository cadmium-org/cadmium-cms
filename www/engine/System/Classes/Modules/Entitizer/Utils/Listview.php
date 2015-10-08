<?php

namespace System\Modules\Entitizer\Utils {

	use System\Modules\Entitizer, System\Utils\Pagination, System\Utils\View, Ajax, Form, Language, Number, Request, Template, Url;

	abstract class Listview {

		protected $index = 0, $parent = null, $items = [];

		# Process parent block

		private function processParent(Template\Utils\Block $parent) {

			# Set parent id

			$parent->id = $this->parent->id;

			# Set parent naming

			$parent->set(static::$naming, $this->parent->__get(static::$naming));

			# Set create button

			$parent->block('create')->id = $this->parent->id;

			# Set edit button

			if (0 === $this->parent->id) $parent->block('edit')->disable();

			else $parent->block('edit')->id = $this->parent->id;
		}

		# Get items block

		private function getItemsBlock($ajax = false) {

			$items = Template::group();

			foreach ($this->items['items'] as $item) {

				$items->add($view = View::get($ajax ? static::$view_ajax_item : static::$view_item));

				# Set data

				$view->id = $item['id']; $view->set(static::$naming, $item[static::$naming]);

				# Set remove button

				$super = (static::$super && ($item['id'] === 1));

				$has_children = (static::$nesting && ($item['children'] > 0));

				$view->block('remove')->class = ((!$super && !$has_children) ? 'negative' : 'disabled');

				# Add item additional data

				$this->processItem($view, $item);
			}

			# ------------------------

			return $items;
		}

		# Get pagination

		private function getPaginationBlock() {

			$url = new Url(static::$link . (static::$nesting ? ('?parent_id=' . $this->parent->id) : ''));

			return Pagination::block($this->index, static::$display, $this->items['total'], $url);
		}

		# Get contents

		private function getContents($ajax = false) {

			$contents = View::get($ajax ? static::$view_ajax_main : static::$view_main);

			# Set path

			if (static::$nesting) $contents->path = $this->parent->path;

			# Process parent block

			if (static::$nesting && !$ajax) $this->processParent($contents->block('parent'));

			# Set items

			$items = $this->getItemsBlock($ajax);

			if ($items->count() > 0) $contents->items = $items;

			# Set pagination

			if (!$ajax) $contents->pagination = $this->getPaginationBlock();

			# Add additional data for specific entity

			$this->processEntity($contents);

			# ------------------------

			return $contents;
		}

		# Handle ajax request

		private function handleAjax() {

			$ajax = Ajax::dataset();

			# Process form

			$form = new Form('ajax'); $form->virtual('id');

			if (false === ($post = $form->post())) return $ajax->error();

			# Create parent entity

			if (static::$nesting) $this->parent = Entitizer::create(static::$type, Request::get('parent_id'));

			# Get children items

			$lister = Entitizer::lister(static::$type);

			$this->items = $lister->select(0, 0, (static::$nesting ? $this->parent->id : 0), $post['id']);

			# ------------------------

			return $ajax->set('contents', $this->getContents(true)->contents(true));
		}

		# Handle common request

		public function handle() {

			if (Request::isAjax()) return $this->handleAjax();

			$this->index = Number::format(Request::get('index'), 1, 999999);

			# Create parent entity

			if (static::$nesting) $this->parent = Entitizer::create(static::$type, Request::get('parent_id'));

			# Get children items

			$lister = Entitizer::lister(static::$type);

			$this->items = $lister->select($this->index, static::$display, (static::$nesting ? $this->parent->id : 0));

			# ------------------------

			return $this->getContents();
		}
	}
}
