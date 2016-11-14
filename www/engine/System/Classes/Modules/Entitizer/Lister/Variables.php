<?php

namespace Modules\Entitizer\Lister {

	use Modules\Entitizer, Template;

	class Variables extends Entitizer\Utils\Lister {

		use Entitizer\Common\Variable;

		protected $title = 'TITLE_CONTENT_VARIABLES';

		# Lister configuration

		protected static $link = '/admin/content/variables';

		protected static $naming = 'title';

		protected static $display = CONFIG_ADMIN_VARIABLES_DISPLAY;

		protected static $view_main = 'Blocks/Entitizer/Variables/Lister/Main';

		protected static $view_item = 'Blocks/Entitizer/Variables/Lister/Item';

		protected static $view_ajax_main = '';

		protected static $view_ajax_item = '';

		# Add additional data for specific entity

		protected function processEntity() {}

		# Add item additional data

		protected function processItem(Template\Block $view, Entitizer\Dataset\Variable $variable) {

			$view->class = '';

			$view->name = $variable->name;

			$view->value = $variable->value;
		}
	}
}
