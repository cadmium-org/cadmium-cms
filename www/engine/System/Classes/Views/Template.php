<?php

namespace System\Views {

	use System\Utils\Extend\Templates;

	class Template extends View {

        # Constructor

        public function __construct($file_name) {

            parent::__construct(Templates::path() . '/' . $file_name);
        }
    }
}
