<?php

/**
 * @package Cadmium\System\Modules\Extend
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Extend\Utils\Handler {

	use Modules\Extend, Ajax, Language, Request, Template;

	abstract class Addons extends Extend\Utils\Handler {

		/**
		 * Process the item block
		 */

		protected function processItem(Template\Block $item, array $data) {

			$browsable = ($data['installed'] && ('' !== $data['browse_url']));

			$item->getBlock('browse')->class = ($browsable ? 'primary' : 'disabled');

			$item->getBlock('browse')->link = $data['browse_url'];

			$item->getBlock($data['installed'] ? 'install' : 'uninstall')->disable();
		}

		/**
		 * Process the contents block
		 */

		protected function processContents(Template\Block $contents) {}

		/**
		 * Handle the ajax request
		 */

		protected function handleAjax() : Ajax\Response {

			$ajax = Ajax::createResponse();

			# Process actions

			if (Request::post('action') === 'install') {

				$name = Request::post('name');

				if (!$this->loader->install($name, true)) return $ajax->setError(Language::get(static::$error_install));

			} else if (Request::post('action') === 'uninstall') {

				$name = Request::post('name');

				if (!$this->loader->install($name, false)) return $ajax->setError(Language::get(static::$error_uninstall));
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

			$this->loader = new static::$loader_class;

			if ($ajax) return $this->handleAjax();

			# ------------------------

			return $this->getContents();
		}
	}
}
