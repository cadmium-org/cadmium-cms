<?php

/**
 * @package Cadmium\System\Modules\Auth
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Auth\Utils {

	use Modules\Auth, Utils\Messages, Utils\View, Language, Request, Template;

	abstract class Action {

		protected $code = null, $user = null, $form = null;

		# Action configuration interface

		protected static $view = '', $form_class = '', $controller_class = '';

		protected static $redirect = '', $messages = [];

		/**
		 * Get the contents block
		 */

		private function getContents() : Template\Block {

			$contents = View::get((Auth::isAdmin() ? 'Blocks/Auth/' : 'Blocks/Profile/Auth/') . static::$view);

			# Set code

			if (null !== $this->code) $contents->code = $this->code;

			# Implement form

			if (null !== $this->form) $this->form->implement($contents);

			# ------------------------

			return $contents;
		}

		/**
		 * Handle the request
		 */

		public function handle() : Template\Block {

			# Create form

			$this->form = new static::$form_class;

			# Handle form

			if ($this->form->handle(new static::$controller_class($this->user))) {

				Request::redirect(INSTALL_PATH . (Auth::isAdmin() ? '/admin' : '/profile') . static::$redirect);
			}

			# Display success message

			foreach (static::$messages as $key => $message) if (Request::get('submitted') === $key) {

				Messages::set('success', Language::get($message['text']), Language::get($message['title']));
			}

			# ------------------------

			return $this->getContents();
		}
	}
}
