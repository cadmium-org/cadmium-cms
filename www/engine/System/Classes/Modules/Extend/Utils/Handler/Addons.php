<?php

namespace Modules\Extend\Utils\Handler {

	use Modules\Extend, Modules\Informer, Ajax, Arr, Language, Request, Template;

	abstract class Addons extends Extend\Utils\Handler {

		# Process item

		protected function processItem(Template\Block $item, array $data) {

			$browsable = ($data['installed'] && ('' !== $data['browse_url']));

			$item->getBlock('browse')->class = ($browsable ? 'primary' : 'disabled');

			$item->getBlock('browse')->link = $data['browse_url'];

			$item->getBlock($data['installed'] ? 'install' : 'uninstall')->disable();
		}

		# Process contents

		protected function processContents(Template\Block $contents) {}

		# Handle ajax request

		protected function handleAjax() {

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

		# Handle common request

		public function handle(bool $ajax = false) {

			$this->loader = new static::$loader_class;

			if ($ajax) return $this->handleAjax();

			# ------------------------

			return $this->getContents();
		}
	}
}
