<?php

namespace System\Modules\Extend\Handler {

    use System\Modules\Extend;

	abstract class Templates extends Extend\Templates {

        use Extend\Utils\Handler;

        private static $error_name = 'TEMPLATES_ERROR_NAME', $errors_save = 'TEMPLATES_ERROR_SAVE';

        private static $view_main = 'Blocks\Extend\Templates\Main', $view_item = 'Blocks\Extend\Templates\Item';
	}
}
