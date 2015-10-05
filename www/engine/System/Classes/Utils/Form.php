<?php

namespace System\Utils {

	use System\Utils\Messages, Language;

	class Form extends \Form {

		# Submit form

		public function submit($callback) {

			if (!is_callable($callback) || (false === ($post = $this->post()))) return false;

			# Check form for errors

			if ($this->errors()) { Messages::error(Language::get('FORM_ERROR_REQUIRED')); return false; }

			# Call controller method

			$result = call_user_func($callback, $post);

			if (true !== $result) { Messages::error(Language::get($result)); return false; }

			# ------------------------

			return true;
		}
	}
}
