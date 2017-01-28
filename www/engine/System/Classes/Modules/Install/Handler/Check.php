<?php

/**
 * @package Cadmium\System\Modules\Install
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Install\Handler {

	use Frames, Modules\Extend, Modules\Install, Utils\View, Language, Template;

	class Check extends Frames\Admin\Area\Install {

		protected $_title = 'TITLE_INSTALL_CHECK';

		private $languages = null;

		/**
		 * Get the requirements loop
		 */

		private function getRequirements() : array {

			$requirements = [];

			foreach (Install::getRequirements() as $name => $status) {

				$class = ($status ? 'positive' : 'negative'); $icon = ($status ? 'check circle' : 'warning circle');

				$text = Language::get('INSTALL_REQUIREMENT_' . strtoupper($name) . '_' . ($status ? 'SUCCESS' : 'FAIL'));

				$requirements[] = ['class' => $class, 'icon' => $icon, 'text' => $text];
			}

			# ------------------------

			return $requirements;
		}

		/**
		 * Get the contents block
		 */

		private function getContents() : Template\Block {

			$contents = View::get('Blocks/Install/Check');

			# Set language

			$contents->getBlock('language')->country = Extend\Languages::data('country');

			$contents->getBlock('language')->title = Extend\Languages::data('title');

			$contents->getBlock('language')->items = $this->languages->items();

			# Set requirements

			$contents->getBlock('requirements')->php_version = phpversion();

			$contents->getBlock('requirements')->items = $this->getRequirements();

			# Set button

			$contents->getBlock('button')->checked = intval($checked = Install::checkRequirements());

			$contents->getBlock('button')->text = Language::get($checked ? 'CONTINUE' : 'RECHECK');

			# ------------------------

			return $contents;
		}

		/**
		 * Handle the request
		 */

		protected function handle() : Template\Block {

			# Load languages

			$this->languages = Extend\Languages::loader(SECTION_ADMIN);

			# ------------------------

			return $this->getContents();
		}
	}
}
