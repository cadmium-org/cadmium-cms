<?php

namespace Error {

	use Exception;

	# Error parent class

	abstract class Error extends Exception {

		protected $message = 'Default error exception thrown';

		# Constructor

		public function __construct($value = '') {

			$value = htmlspecialchars($value);

			$this->message = str_replace('$value$', $value, $this->message);
		}

		# Return message

		public function message() {

			return $this->message;
		}
	}

	# General error

	class General extends Error {

		# Constructor override

		public function __construct($message = '') {

			if ('' !== ($message = strval($message))) $this->message = $message;
		}
	}

	# Class load error

	class ClassLoad extends Error  {

		protected $message = 'Class \'$value$\' not found';
	}

	# Database connect error

	class DBConnect extends Error  {

		protected $message = 'Unable to connect to database';
	}

	# Database select error

	class DBSelect extends Error  {

		protected $message = 'Unable to select database';
	}

	# Database charset error

	class DBCharset extends Error  {

		protected $message = 'Unable to set database charset';
	}

	# Language init error

	class LanguageInit extends Error {

		protected $message = 'Unable to init language \'$value$\'';
	}
}
