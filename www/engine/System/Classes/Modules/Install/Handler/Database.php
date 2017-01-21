<?php

/**
 * @package Cadmium\System\Modules\Install
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Install\Handler {

	use Frames, Modules\Install, Utils\View, Request, Template;

	class Database extends Frames\Admin\Area\Install {

		protected $_title = 'TITLE_INSTALL_DATABASE';

		private $form = null;

		/**
		 * Get the contents block
		 */

		private function getContents() : Template\Block {

			$contents = View::get('Blocks/Install/Database');

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

			$this->form = new Install\Form\Database;

			# Handle form

			if ($this->form->handle(new Install\Controller\Database)) {

				Request::redirect(INSTALL_PATH . '/admin/register');
			}

			# ------------------------

			return $this->getContents();
		}
	}
}
