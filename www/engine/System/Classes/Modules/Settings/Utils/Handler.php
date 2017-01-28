<?php

/**
 * @package Cadmium\System\Modules\Settings
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Settings\Utils {

	use Frames, Utils\Popup, Utils\View, Language, Request, Template;

	abstract class Handler extends Frames\Admin\Area\Panel {

		protected $_title = 'TITLE_SYSTEM_SETTINGS';

		private $form = null;

		/**
		 * Get the contents block
		 */

		private function getContents() : Template\Block {

			$contents = View::get(static::$view);

			# Implement form

			$this->form->implement($contents);

			# ------------------------

			return $contents;
		}

		/**
		 * Handle the request
		 */

		protected function handle() : Template\Block {

			# Create form

			$this->form = new static::$form_class;

			# Handle form

			if ($this->form->handle(new static::$controller_class, true)) {

				Request::redirect(INSTALL_PATH . (static::$url . '?submitted'));
			}

			# Display success message

			if (false !== Request::get('submitted')) Popup::set('positive', Language::get('SETTINGS_SUCCESS'));

			# ------------------------

			return $this->getContents();
		}
	}
}
