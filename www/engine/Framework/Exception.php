<?php

namespace Exception {

	# Exception parent class

	abstract class Exception extends \Exception {

		protected $message = 'Default exception thrown';

		/**
		 * Constructor
		 */

		public function __construct(string $value = '') {

			$value = htmlspecialchars($value);

			$this->message = str_replace('$value$', $value, $this->message);
		}
	}

	# General exception

	class General extends Exception {

		/**
		 * Constructor override
		 */

		public function __construct(string $message = '') {

			if ('' !== $message) $this->message = $message;
		}
	}

	# Class load exception

	class ClassLoad extends Exception  {

		protected $message = 'Class \'$value$\' not found';
	}

	# Database connect exception

	class DBConnect extends Exception  {

		protected $message = 'Unable to connect to database';
	}

	# Database charset exception

	class DBCharset extends Exception  {

		protected $message = 'Unable to set database charset';
	}

	# Database select exception

	class DBSelect extends Exception  {

		protected $message = 'Unable to select database';
	}
}
