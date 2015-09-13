<?php

namespace System\Modules\Extend\Handler {

    use System\Modules\Extend;

	abstract class Languages extends Extend\Languages {

        use Extend\Utils\Handler;

        private static $error_name = 'LANGUAGES_ERROR_NAME', $errors_save = 'LANGUAGES_ERROR_SAVE';

        private static $view_main = 'Blocks\Extend\Languages\Main', $view_item = 'Blocks\Extend\Languages\Item';
	}
}
