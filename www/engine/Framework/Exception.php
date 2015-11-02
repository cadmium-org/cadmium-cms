<?php

namespace Exception {

	# Error parent class

	abstract class Exception extends \Exception {

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

	class General extends Exception {

		# Constructor override

		public function __construct($message = '') {

			if ('' !== ($message = strval($message))) $this->message = $message;
		}
	}

	# Class load error

	class ClassLoad extends Exception  {

		protected $message = 'Class \'$value$\' not found';
	}

	# Database connect error

	class DBConnect extends Exception  {

		protected $message = 'Unable to connect to database';
	}

	# Database select error

	class DBSelect extends Exception  {

		protected $message = 'Unable to select database';
	}

	# Database charset error

	class DBCharset extends Exception  {

		protected $message = 'Unable to set database charset';
	}

	# Language init error

	class LanguageInit extends Exception {

		protected $message = 'Unable to init language \'$value$\'';
	}
}
