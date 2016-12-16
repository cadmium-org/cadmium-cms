<?php

/**
 * @package Cadmium\Framework
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Exception {

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

	class General extends Exception {

		/**
		 * Constructor override
		 */

		public function __construct(string $message = '') {

			if ('' !== $message) $this->message = $message;
		}
	}

	class ClassLoad extends Exception  {

		protected $message = 'Class \'$value$\' not found';
	}

	class DBConnect extends Exception  {

		protected $message = 'Unable to connect to database';
	}

	class DBCharset extends Exception  {

		protected $message = 'Unable to set database charset';
	}

	class DBSelect extends Exception  {

		protected $message = 'Unable to select database';
	}
}
