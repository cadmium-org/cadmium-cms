<?php

namespace Modules\Extend\Utils\Handler {

	use Modules\Extend, Modules\Settings, Ajax, Arr, Language, Request, Template, JSON;

	abstract class Basic extends Extend\Utils\Handler {

		# Process item

		protected function processItem(Template\Block $item, array $data) {

			$item->class = (($data['name'] === $this->loader->data('name')) ? 'positive' : 'grey');
		}

		# Process contents

		protected function processContents(Template\Block $contents) {

			$contents->section = $this->loader->section();
		}

		# Handle ajax request

		protected function handleAjax() {

			$ajax = Ajax::createResponse();

			# Process actions

			if (Request::post('action') === 'activate') {

				$param = static::$param[$this->loader->section()]; $name = Request::post('name');

				if (false === Settings::set($param, $name)) return $ajax->setError(Language::get(static::$error_activate));

				if (false === Settings::save()) return $ajax->setError(Language::get(static::$error_save));

			} else if (Request::post('action') === 'list') {

				$ajax->set('items', $this->loader->items());
			}

			# ------------------------

			return $ajax;
		}

		# Handle common request

		public function handle(bool $ajax = false) {

			$this->loader = new static::$loader_class(Request::get('list'));

			if ($ajax) return $this->handleAjax();

			# ------------------------

			return $this->getContents();
		}
	}
}
