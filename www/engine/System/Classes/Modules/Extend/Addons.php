<?php

/**
 * @package Cadmium\System\Modules\Extend
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Extend {

	use Modules\Extend;

	abstract class Addons extends Utils\Extension\Addons {

		use Extend\Common\Addons;

		protected static $loader = null;
	}
}
