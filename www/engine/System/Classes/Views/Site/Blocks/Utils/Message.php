<?php

namespace System\Views\Site\Blocks\Utils {

	use System\Views;

	class Message extends Views\Templatable {

		# Constructor

        public function __construct() {

            parent::__construct(SECTION_SITE, 'Blocks/Utils/Message.tpl');
        }
    }
}
