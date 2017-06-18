<?php

/**
 * @package Cadmium\System\Modules\Extend
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Extend\Utils\Handler {

	use Modules\Extend, Ajax, Language, Request, Template;

	abstract class Basic extends Extend\Utils\Handler {

		/**
		 * Process the item block
		 */

		protected function processItem(Template\Block $item, array $data) {

			$item->class = (($data['name'] === $this->loader->get('name')) ? 'positive' : 'grey');
		}

		/**
		 * Process the contents block
		 */

		protected function processContents(Template\Block $contents) {

			$contents->section = $this->loader->getSection();
		}

		/**
		 * Handle the ajax request
		 */

		protected function handleAjax() : Ajax\Response {

			$ajax = Ajax::createResponse();

			# Process actions

			if (Request::post('action') === 'activate') {

				$name = Request::post('name');

				if (!$this->loader->activate($name, true)) return $ajax->setError(Language::get(static::$error_activate));

			} else if (Request::post('action') === 'list') {

				$ajax->set('items', $this->loader->getItems());
			}

			# ------------------------

			return $ajax;
		}

		/**
		 * Handle the request
		 *
		 * @return Template\Block|Ajax\Response : a block object if the ajax param was set to false, otherwise an ajax response
		 */

		public function handle(bool $ajax = false) {

			$this->loader = new static::$loader_class(Request::get('list'));

			if ($ajax) return $this->handleAjax();

			# ------------------------

			return $this->getContents();
		}
	}
}
