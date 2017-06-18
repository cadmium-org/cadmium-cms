<?php

/**
 * @package Cadmium\System\Modules\Extend
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Extend\Handler {

	use Modules\Extend;

	class Addons extends Extend\Utils\Handler\Addons {

		use Extend\Common\Addons;

		protected $_title = 'TITLE_EXTEND_ADDONS';
	}
}
