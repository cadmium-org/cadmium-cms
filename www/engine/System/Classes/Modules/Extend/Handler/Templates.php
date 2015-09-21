<?php

namespace System\Modules\Extend\Handler {

    use System\Modules\Extend;

	class Templates extends Extend\Templates {

        use Extend\Utils\Handler;

        protected static $error_name = 'TEMPLATES_ERROR_NAME', $errors_save = 'TEMPLATES_ERROR_SAVE';

        protected static $view_main = 'Blocks\Extend\Templates\Main', $view_item = 'Blocks\Extend\Templates\Item';
	}
}
