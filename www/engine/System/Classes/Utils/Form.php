<?php

namespace System\Utils {

	use System\Utils\Messages, Language;

	abstract class Form extends \Form {

		# Parse errors

		private function parseErrors(array $errors) {

			if (isset($errors['required'])) return Messages::error(Language::get('FORM_ERROR_REQUIRED'));

			if (isset($errors['format'])) return Messages::error(Language::get('FORM_ERROR_FORMAT'));
		}

		# Submit form

		public function submit(callable $callback) {

			if (false === ($post = $this->post())) return false;

			# Check form for errors and set an appropriate message

			if ([] !== ($errors = $this->errors())) { $this->parseErrors($errors); return false; }

			# Call controller method

			if (true !== $callback($post)) { Messages::error(Language::get($result)); return false; }

			# ------------------------

			return true;
		}
	}
}
