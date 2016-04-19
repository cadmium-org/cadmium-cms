<?php

namespace Modules\Entitizer\Utils {

	use Modules\Entitizer, Utils\Pagination, Utils\View, Ajax, Number, Request, Template, Url;

	abstract class Lister {

		protected $index = 0, $parent = null, $entity = null, $path = [], $depth = 0;

		protected $items = ['list' => [], 'total' => 0];

		# Process parent block

		private function processParent(Template\Asset\Block $parent) {

			# Set parent id

			$parent->id = $this->parent->id;

			# Set create button

			if (count($this->path) < CONFIG_ENTITIZER_MAX_DEPTH) $parent->block('create')->id = $this->parent->id;

			else { $parent->block('create')->disable(); $parent->block('create_disabled')->enable(); }

			# Set edit button

			if (0 !== $this->parent->id) $parent->block('edit')->id = $this->parent->id;

			else { $parent->block('edit')->disable(); $parent->block('edit_disabled')->enable(); }

			# Add parent additional data

			$this->processEntityParent($parent);
		}

		# Get items block

		private function getItemsBlock(bool $ajax = false) {

			$items = Template::group();

			foreach ($this->items['list'] as $item) {

				if ((null !== $this->entity) && ($item['dataset']->id === $this->entity->id)) continue;

				$items->add($view = View::get(!$ajax ? static::$view_item : static::$view_ajax_item));

				# Set data

				$view->id = $item['dataset']->id;

				$view->set(static::$naming, $item['dataset']->get(static::$naming));

				# Set buttons

				if (!$ajax) {

					$super = (static::$super && ($item['dataset']->id === 1));

					$has_children = (static::$nesting && ($item['children'] > 0));

					$view->block('remove')->class = ((!$super && !$has_children) ? 'negative' : 'disabled');

				} else {

					$selectable = ((count($this->path) + $this->depth + 1) < CONFIG_ENTITIZER_MAX_DEPTH);

					$view->block('select')->class = ($selectable ? 'grey' : 'disabled');
				}

				# Add item additional data

				$this->processItem($view, $item['dataset'], (static::$nesting ? $item['children'] : 0));
			}

			# ------------------------

			return $items;
		}

		# Get pagination block

		private function getPaginationBlock() {

			$query = (static::$nesting ? ('?parent_id=' . $this->parent->id) : '');

			$url = new Url(INSTALL_PATH . static::$link . $query);

			# ------------------------

			return Pagination::block($this->index, static::$display, $this->items['total'], $url);
		}

		# Get contents

		private function getContents(bool $ajax = false) {

			$contents = View::get(!$ajax ? static::$view_main : static::$view_ajax_main);

			# Set path

			if (static::$nesting) $contents->path = $this->path;

			# Process parent block

			if (static::$nesting && !$ajax) $this->processParent($contents->block('parent'));

			# Set items

			$items = $this->getItemsBlock($ajax);

			if ($items->count() > 0) $contents->items = $items;

			# Set pagination

			if (!$ajax) $contents->pagination = $this->getPaginationBlock();

			# ------------------------

			return $contents;
		}

		# Handle ajax request

		private function handleAjax() {

			$ajax = Ajax::response();

			# Create parent entity

			$parent_id = (static::$nesting ? Number::format(Request::get('parent_id')) : 0);

			$this->parent = Entitizer::get(static::$table, $parent_id);

			# Create active entity

			$this->entity = Entitizer::get(static::$table, Number::format(Request::post('id')));

			# Get path and depth

			if (false !== ($path = $this->parent->path())) $this->path = $path;

			if ((0 !== $this->entity->id) && (false !== ($depth = $this->entity->subtreeDepth()))) $this->depth = $depth;

			# Get items list

			$lister = (static::$nesting ? 'children' : 'items');

			if (false !== ($items = $this->parent->$lister())) $this->items = $items;

			# ------------------------

			return $ajax->set('contents', $this->getContents(true)->contents());
		}

		# Handle common request

		public function handle() {

			if (Request::isAjax()) return $this->handleAjax();

			$this->index = Number::format(Request::get('index'), 1, 999999);

			# Create parent entity

			$parent_id = (static::$nesting ? Number::format(Request::get('parent_id')) : 0);

			$this->parent = Entitizer::get(static::$table, $parent_id);

			# Get path

			if (false !== ($path = $this->parent->path())) $this->path = $path;

			# Get items list

			$lister = (static::$nesting ? 'children' : 'items'); $index = $this->index; $display = static::$display;

			if (false !== ($items = $this->parent->$lister([], [], $index, $display))) $this->items = $items;

			# ------------------------

			return $this->getContents();
		}
	}
}
