<?php

namespace Warning {

	use Exception;

	# Warning parent class

	abstract class Warning extends Exception {

		protected $message = 'Default warning exception thrown';

		# Constructor

		public function __construct($value = false) {

			$value = htmlspecialchars($value);

			$this->message = str_replace('$value$', $value, $this->message);
		}

		# Return message

		public function message() {

			return $this->message;
		}
	}

	# General warning

	class General extends Warning {

		# Constructor override

		public function __construct($message = false) {

			if ('' !== ($message = strval($message))) $this->message = $message;
		}
	}

	# Language init warning

	class LanguageInit extends Warning {

		protected $message = 'Unable to init language \'$value$\'';
	}

	# Template init warning

	class TemplateInit extends Warning {

		protected $message = 'Unable to init template \'$value$\'';
	}
}

?>
