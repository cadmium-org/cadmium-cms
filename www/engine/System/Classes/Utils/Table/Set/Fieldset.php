<?php

namespace System\Utils\Table\Set {

	use Number, String, Validate;

	class Fieldset {

		private $fieldset = false;

		# Add id field

        public function id($name, $auto_increment = false) {

            $name = String::validate($name); $auto_increment = Validate::boolean($auto_increment);

            $default = ($auto_increment ? "AUTO_INCREMENT" : "DEFAULT '0'");

            $this->fieldset[] = ("`" . $name . "` int(10) unsigned NOT NULL " . $default);
        }

		# Add boolean field

        public function boolean($name, $default = false) {

            $name = String::validate($name); $default = Number::unsigned($default, 1);

            $this->fieldset[] = ("`" . $name . "` tinyint(1) unsigned NOT NULL DEFAULT '" . $default . "'");
        }

		# Add range field

        public function range($name, $default = false) {

            $name = String::validate($name); $default = Number::unsigned($default, 99);

            $this->fieldset[] = ("`" . $name . "` tinyint(2) unsigned NOT NULL DEFAULT '" . $default . "'");
        }

		# Add varchar field

        public function varchar($name, $maxlength = false) {

            $name = String::validate($name); $maxlength = Number::unsigned($maxlength);

            $this->fieldset[] = ("`" . $name . "` varchar(" . $maxlength . ") NOT NULL");
        }

		# Add hash field

        public function hash($name) {

            $name = String::validate($name);

            $this->fieldset[] = ("`" . $name . "` varchar(40) CHARACTER SET utf8 COLLATE utf8_bin NOT NULL");
        }

		# Add text field

        public function text($name) {

            $name = String::validate($name);

            $this->fieldset[] = ("`" . $name . "` text NOT NULL");
        }

		# Add time field

        public function time($name) {

            $name = String::validate($name);

            $this->fieldset[] = ("`" . $name . "` int(10) unsigned NOT NULL DEFAULT '0'");
        }

		# Return array

        public function get() {

            return $this->fieldset;
        }
    }
}

?>
