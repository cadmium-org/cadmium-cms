<?php

namespace System\Utils {

	use System\Utils\Messages, Language;

	abstract class Form extends \Form {

		# Handle form

		public function handle(callable $callback) {

			if (false === ($post = $this->post())) return false;

			# Check form for errors

			if ($this->errors()) { Messages::error(Language::get('FORM_ERROR_REQUIRED')); return false; }

			# Call controller method

			if (is_string($result = $callback($post))) { Messages::error(Language::get($result)); return false; }

			# ------------------------

			return (true === $result);
		}
	}
}
