<?php

/**
 * @package Cadmium\System\Addons\Contact
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Addons\Contact {

	use Frames, Modules\Auth, Utils\Messages, Utils\View, Language, Request, Template;

	class Handler extends Frames\Site\Area\Common {

		protected $title = 'TITLE_CONTACT';

		private $form = null;

		/**
		 * Get the contents block
		 */

		private function getContents() : Template\Block {

			$contents = View::get('Blocks/Contact/Contact');

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

			$this->form = new Form;

			# Handle form

			if ($this->form->handle(new Controller)) Request::redirect(INSTALL_PATH . '/contact?submitted');

			# Display success message

			if (false !== Request::get('submitted')) Messages::set('success', Language::get('CONTACT_SUCCESS_SEND'));

			# ------------------------

			return $this->getContents();
		}
	}
}
