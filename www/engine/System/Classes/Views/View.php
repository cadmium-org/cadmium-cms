<?php

namespace System\Views {

	use Explorer, Template;

	abstract class View extends Template\Utils\Block {

        # Constructor

        public function __construct($file_name) {

            if (false !== ($contents = Explorer::contents($file_name))) parent::__construct($contents);
        }
    }
}
