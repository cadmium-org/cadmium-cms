<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Utils {

	use Frames, Modules\Entitizer, Modules\Settings, Utils\Pagination, Utils\View, Ajax, Number, Request, Template, Url;

	abstract class Lister extends Frames\Admin\Area\Panel {

		protected $index = 0, $parent = null, $entity = null, $path = [], $depth = 0;

		protected $items = ['list' => [], 'total' => 0];

		/**
		 * Process the parent block
		 */

		private function processParent(Template\Block $parent) {

			# Set parent id

			$parent->id = $this->parent->id;

			# Set create button

			if (count($this->path) < CONFIG_ENTITIZER_MAX_DEPTH) $parent->getBlock('create')->id = $this->parent->id;

			else { $parent->getBlock('create')->disable(); $parent->getBlock('create_disabled')->enable(); }

			# Set edit button

			if (0 !== $this->parent->id) $parent->getBlock('edit')->id = $this->parent->id;

			else { $parent->getBlock('edit')->disable(); $parent->getBlock('edit_disabled')->enable(); }

			# Add parent additional data

			$this->processEntityParent($parent);
		}

		/**
		 * Process the items block
		 */

		private function processItems(Template\Block $items, bool $ajax = false) {

			foreach ($this->items['list'] as $item) {

				if ((null !== $this->entity) && ($item['dataset']->id === $this->entity->id)) continue;

				$items->addItem($view = View::get(!$ajax ? static::$view_item : static::$view_ajax_item));

				# Set data

				$view->id = $item['dataset']->id;

				$view->set(static::$naming, $item['dataset']->get(static::$naming));

				# Set buttons

				if (!$ajax) {

					if (static::$nesting) {

						$fertile = ((count($this->path) + 1) < CONFIG_ENTITIZER_MAX_DEPTH);

						$view->getBlock('create')->class = ($fertile ? 'olive' : 'disabled');

						$view->getBlock('create')->id = $item['dataset']->id;
					}

					$super = (static::$super && ($item['dataset']->id === 1));

					$has_children = (static::$nesting && ($item['children'] > 0));

					$view->getBlock('remove')->class = ((!$super && !$has_children) ? 'negative' : 'disabled');

				} else {

					$selectable = ((count($this->path) + $this->depth + 1) < CONFIG_ENTITIZER_MAX_DEPTH);

					$view->getBlock('select')->class = ($selectable ? 'grey' : 'disabled');
				}

				# Add item additional data

				$this->processItem($view, $item['dataset'], (static::$nesting ? $item['children'] : 0));
			}
		}

		/**
		 * Get the pagination block
		 *
		 * @return Template\Block|false : a block or false if there is only a single page
		 */

		private function getPaginationBlock() {

			$query = (static::$nesting ? ('?parent_id=' . $this->parent->id) : '');

			$url = new Url(INSTALL_PATH . static::$link . $query);

			# ------------------------

			return Pagination::block($this->index, Settings::get('admin_display_entities'), $this->items['total'], $url);
		}

		/**
		 * Get the contents block
		 */

		private function getContents(bool $ajax = false) : Template\Block {

			$contents = View::get(!$ajax ? static::$view_main : static::$view_ajax_main);

			# Set path

			if (static::$nesting) $contents->path = $this->path;

			# Process parent block

			if (static::$nesting && !$ajax) $this->processParent($contents->getBlock('parent'));

			# Process items block

			$this->processItems($contents->getBlock('items'), $ajax);

			# Set pagination

			if (!$ajax) $contents->pagination = $this->getPaginationBlock();

			# ------------------------

			return $contents;
		}

		/**
		 * Handle the ajax request
		 */

		private function handleAjax() : Ajax\Response {

			$ajax = Ajax::createResponse();

			# Create parent entity

			$parent_id = (static::$nesting ? Number::forceInt(Request::get('parent_id')) : 0);

			$this->parent = Entitizer::get(static::$table, $parent_id);

			# Create active entity

			$this->entity = Entitizer::get(static::$table, Number::forceInt(Request::post('id')));

			# Get path and depth

			if (false !== ($path = $this->parent->getPath())) $this->path = $path;

			if ((0 !== $this->entity->id) && (false !== ($depth = $this->entity->getSubtreeDepth()))) $this->depth = $depth;

			# Get items list

			$lister = (static::$nesting ? 'getChildren' : 'getItems');

			if (false !== ($items = $this->parent->$lister())) $this->items = $items;

			# ------------------------

			return $ajax->set('contents', $this->getContents(true)->getContents());
		}

		/**
		 * Handle the request
		 *
		 * @return Template\Block|Ajax\Response | a block object if the ajax param was set to false, otherwise an ajax response
		 */

		protected function handle(bool $ajax = false) {

			if ($ajax) return $this->handleAjax();

			$this->index = Number::forceInt(Request::get('index'), 1, 999999);

			# Create parent entity

			$parent_id = (static::$nesting ? Number::forceInt(Request::get('parent_id')) : 0);

			$this->parent = Entitizer::get(static::$table, $parent_id);

			# Get path

			if (false !== ($path = $this->parent->getPath())) $this->path = $path;

			# Get items list

			$lister = (static::$nesting ? 'getChildren' : 'getItems'); $display = Settings::get('admin_display_entities');

			if (false !== ($items = $this->parent->$lister([], [], $this->index, $display))) $this->items = $items;

			# ------------------------

			return $this->getContents();
		}
	}
}
