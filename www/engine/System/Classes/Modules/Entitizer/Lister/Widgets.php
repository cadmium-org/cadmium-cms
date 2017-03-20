<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Lister {

	use Modules\Entitizer, Template;

	class Widgets extends Entitizer\Utils\Lister {

		use Entitizer\Common\Widget;

		protected $_title = 'TITLE_CONTENT_WIDGETS';

		# Lister configuration

		protected static $naming = 'title';

		protected static $view_main = 'Blocks/Entitizer/Widgets/Lister/Main';

		protected static $view_item = 'Blocks/Entitizer/Widgets/Lister/Item';

		protected static $view_ajax_main = 'Blocks/Entitizer/Widgets/Ajax/Main';

		protected static $view_ajax_item = 'Blocks/Entitizer/Widgets/Ajax/Item';

		protected static $link = '/admin/content/widgets';

		# Add additional data for specific entity

		protected function processEntity() {}

		/**
		 * Add item's additional data
		 */

		protected function processItem(Template\Block $view, Entitizer\Dataset\Widget $widget) {

			$view->class = (!$widget->active ? 'inactive' : '');

			$view->name = $widget->name;
		}
	}
}
