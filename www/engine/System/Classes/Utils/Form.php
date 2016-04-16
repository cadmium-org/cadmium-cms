<?php

namespace Utils {

	use Utils\Messages, Utils\Popup, Language;

	abstract class Form extends \Form {

		# Display error

		private function displayError(string $code, bool $popup) {

			$text = Language::get($code);

			if (!$popup) Messages::set('error', $text); else Popup::set('negative', $text);

			# ------------------------

			return false;
		}

		# Handle form

		public function handle(callable $callback, bool $popup = false) {

			if (false === ($post = $this->post())) return false;

			# Check form for errors

			if ($this->errors()) return $this->displayError('FORM_ERROR_REQUIRED', $popup);

			# Call controller method

			if (is_string($result = $callback($post))) return $this->displayError($result, $popup);

			if (is_array($result)) { $this->get($result[0])->error(true); return $this->displayError($result[1], $popup); }

			# ------------------------

			return (true === $result);
		}
	}
}
