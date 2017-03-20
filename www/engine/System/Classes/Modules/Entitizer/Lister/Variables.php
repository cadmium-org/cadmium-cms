<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Lister {

	use Modules\Entitizer, Template;

	class Variables extends Entitizer\Utils\Lister {

		use Entitizer\Common\Variable;

		protected $_title = 'TITLE_CONTENT_VARIABLES';

		# Lister configuration

		protected static $naming = 'title';

		protected static $view_main = 'Blocks/Entitizer/Variables/Lister/Main';

		protected static $view_item = 'Blocks/Entitizer/Variables/Lister/Item';

		protected static $view_ajax_main = 'Blocks/Entitizer/Variables/Ajax/Main';

		protected static $view_ajax_item = 'Blocks/Entitizer/Variables/Ajax/Item';

		protected static $link = '/admin/content/variables';

		# Add additional data for specific entity

		protected function processEntity() {}

		/**
		 * Add item's additional data
		 */

		protected function processItem(Template\Block $view, Entitizer\Dataset\Variable $variable) {

			$view->class = '';

			$view->name = $variable->name;

			$view->value = $variable->value;
		}
	}
}
