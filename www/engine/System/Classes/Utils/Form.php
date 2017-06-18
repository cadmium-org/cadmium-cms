<?php

/**
 * @package Cadmium\System\Utils
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Utils {

	use Utils\Messages, Utils\Popup, Language;

	abstract class Form extends \Form {

		/**
		 * Display an error message
		 *
		 * @return false : the method always returns false
		 */

		private function displayError(string $phrase, bool $popup) : bool {

			$text = Language::get($phrase);

			if (!$popup) Messages::set('error', $text); else Popup::set('negative', $text);

			# ------------------------

			return false;
		}

		/**
		 * Handle the form. The method catches POST data and passes it to a callback function.
		 * If the function call fails, an error message will be displayed.
		 *
		 * @param $popup : tells to display a popup error message instead of a regular message
		 *
		 * @return bool : true on success or false on failure
		 */

		public function handle(callable $callback, bool $popup = false) : bool {

			if (false === ($post = $this->post())) return false;

			# Check form for errors

			if ($this->hasErrors()) return $this->displayError('FORM_ERROR_REQUIRED', $popup);

			# Call controller method and display error

			if (is_string($result = $callback($post))) return $this->displayError($result, $popup);

			if (is_array($result)) return (($this->getField($result[0])->error = true) && $this->displayError($result[1], $popup));

			# ------------------------

			return (true === $result);
		}
	}
}
