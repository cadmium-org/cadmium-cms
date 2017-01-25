<?php

/**
 * @package Cadmium\System\Modules\Settings
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Settings\Handler {

	use Frames, Modules\Settings, Utils\Popup, Utils\View, Language, Request, Template;

	class Common extends Frames\Admin\Area\Panel {

		protected $_title = 'TITLE_SYSTEM_SETTINGS';

		private $form = null;

		/**
		 * Get the contents block
		 */

		private function getContents() : Template\Block {

			$contents = View::get('Blocks/Settings/Common');

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

			$this->form = new Settings\Form\Common;

			# Handle form

			if ($this->form->handle(new Settings\Controller\Common, true)) {

				Request::redirect(INSTALL_PATH . '/admin/system/settings?submitted');
			}

			# Display success message

			if (false !== Request::get('submitted')) Popup::set('positive', Language::get('SETTINGS_SUCCESS'));

			# ------------------------

			return $this->getContents();
		}
	}
}
