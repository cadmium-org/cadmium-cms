<?php

/**
 * @package Cadmium\System\Frames\Admin
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Frames\Admin {

	use Modules\Extend, Ajax, Language, Template;

	abstract class View extends \Utils\View {

		protected $view = '', $status = STATUS_CODE_200, $title = '';

		/**
		 * Get the page title
		 */

		private function getTitle() : string {

			return ((('' !== $this->title) ? (Language::get($this->title) . ' | ') : '') . CADMIUM_NAME);
		}

		/**
		 * Output the page contents
		 */

		protected function _display(Template\Block $layout) {

			$view = View::get('Main/' . $this->view);

			# Set language

			$view->language = Extend\Languages::data('iso');

			# Set title

			$view->title = $this->getTitle();

			# Set layout

			$view->layout = $layout;

			# ------------------------

			Template::output($view, $this->status);
		}

		/**
		 * Output the page dynamic data as json
		 */

		protected function _navigate(array $layout) {

			$response = Ajax::createResponse(['navigate' => true]);

			# Set language

			$response->language = Extend\Languages::data('iso');

			# Set title

			$response->title = $this->getTitle();

			# Set layout

			$response->layout = $layout;

			# ------------------------

			Ajax::output($response);
		}

		/**
		 * Constructor
		 */

		public function __construct(string $title) {

			$this->title = $title;
		}
	}
}
