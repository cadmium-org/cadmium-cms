<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Handler\Create {

	use Modules\Entitizer;

	class Page extends Entitizer\Handler\Edit\Page {

		protected $_title = 'TITLE_CONTENT_PAGES_CREATE';

		protected $create = true;
	}
}
