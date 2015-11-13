<?php

namespace System\Utils {

	use System\Utils\Messages, Language;

	abstract class Form extends \Form {

		# Submit form

		public function submit(callable $callback) {

			if (false === ($post = $this->post())) return false;

			# Check form for errors and set an appropriate message

			if ($this->errors()) { Messages::error(Language::get('FORM_ERROR_REQUIRED')); return false; }

			# Call controller method

			$result = call_user_func($callback, $post);

			if (true !== $result) { Messages::error(Language::get($result)); return false; }

			# ------------------------

			return true;
		}
	}
}
