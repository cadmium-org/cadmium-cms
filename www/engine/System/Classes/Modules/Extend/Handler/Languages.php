<?php

namespace System\Modules\Extend\Handler {

    use System\Modules\Extend;

	class Languages extends Extend\Languages {

        use Extend\Utils\Handler;

        protected static $error_name = 'LANGUAGES_ERROR_NAME', $errors_save = 'LANGUAGES_ERROR_SAVE';

        protected static $view_main = 'Blocks\Extend\Languages\Main', $view_item = 'Blocks\Extend\Languages\Item';
	}
}
