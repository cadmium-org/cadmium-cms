<?php

/**
 * @package Cadmium\System\Modules\Filemanager
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Filemanager\Container {

	use Modules\Filemanager;

	class Languages extends Filemanager\Utils\Container {

		use Filemanager\Common\Languages;

		protected $path_full = DIR_SYSTEM_LANGUAGES;
	}
}
