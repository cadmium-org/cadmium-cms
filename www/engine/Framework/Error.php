<?php

namespace Error {

	use Exception;

	class Error extends Exception {

		protected $message = "Default exception thrown";

		public function __construct($value = '') {

			$value = htmlspecialchars($value);

			$this->message = str_replace('%value%', $value, $this->message);
		}

		public function message() {

			return $this->message;
		}
	}

	class General extends Error {

		public function __construct($message = '') {

			if ('' !== ($message = strval($message))) $this->message = $message;
		}
	}

	class ClassLoad extends Error  {

		protected $message = "Class '%value%' not found";
	}

	class DBCharset extends Error  {

		protected $message = "Unable to set database charset";
	}

	class DBConnect extends Error  {

		protected $message = "Unable to connect to database";
	}

	class DBSelect extends Error  {

		protected $message = "Unable to select database";
	}

	class LanguageInit extends Error {

		protected $message = "Unable to init language '%value%'";
	}

	class TemplateInit extends Error {

		protected $message = "Unable to init template '%value%'";
	}
}

?>
