<?php

/**
 * @package Cadmium\System\Modules\Settings
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Settings\Handler {

	use Modules\Settings;

	class Admin extends Settings\Utils\Handler {

		# Handler configuration

		protected static $form_class = 'Modules\Settings\Form\Admin';

		protected static $controller_class = 'Modules\Settings\Controller\Admin';

		protected static $url = '/admin/system/settings/admin';

		protected static $view = 'Blocks/Settings/Admin';
	}
}
