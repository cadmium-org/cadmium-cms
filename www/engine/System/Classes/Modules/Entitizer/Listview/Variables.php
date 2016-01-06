<?php

namespace Modules\Entitizer\Listview {

	use Modules\Entitizer, Template;

	class Variables extends Entitizer\Utils\Listview {

		use Entitizer\Common\Variable;

		# Listview configuration

		protected static $lister = 'Modules\Entitizer\Lister\Variables';

		protected static $link = '/admin/content/variables';

		protected static $naming = 'title';

		protected static $display = CONFIG_ADMIN_VARIABLES_DISPLAY;

		protected static $view_main = 'Blocks\Entitizer\Variables\Listview\Main';

		protected static $view_item = 'Blocks\Entitizer\Variables\Listview\Item';

		protected static $view_ajax_main = '';

		protected static $view_ajax_item = '';

		# Add additional data for specific entity

		protected function processEntity() {}

		# Add item additional data

		protected function processItem(Template\Asset\Block $view, Entitizer\Entity\Variable $variable) {

			$view->name = $variable->name;

			$view->value = $variable->value;
		}
	}
}
