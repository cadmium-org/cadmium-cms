<?php

namespace Modules\Extend {

	use Modules\Extend;

	abstract class Addons extends Utils\Extension\Addons {

		use Extend\Common\Addons;

		protected static $loader = null;
	}
}
