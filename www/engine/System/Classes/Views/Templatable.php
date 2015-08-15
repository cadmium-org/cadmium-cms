<?php

namespace System\Views {

	use System\Utils\Extend\Templates;

	class Templatable extends View {

        # Constructor

        public function __construct($section, $file_name) {

			if ($section !== Templates::section()) return;

			parent::__construct(Templates::path() . '/' . $file_name);
        }
    }
}
