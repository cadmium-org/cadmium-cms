<?php

namespace System\Modules\Entitizer\Listview {

	use System\Modules\Entitizer, Template, Language;

	class Widgets extends Entitizer\Utils\Listview {

		use Entitizer\Common\Widget;

		# Listview configuration

		protected static $lister = 'System\Modules\Entitizer\Lister\Widgets';

		protected static $link = '/admin/content/widgets';

		protected static $naming = 'title';

		protected static $display = CONFIG_ADMIN_WIDGETS_DISPLAY;

		protected static $view_main = 'Blocks\Entitizer\Widgets\Listview\Main';

		protected static $view_item = 'Blocks\Entitizer\Widgets\Listview\Item';

		protected static $view_ajax_main = '';

		protected static $view_ajax_item = '';

		# Add additional data for specific entity

		protected function processEntity() {}

		# Add item additional data

		protected function processItem(Template\Asset\Block $view, Entitizer\Entity\Widget $widget) {

			$view->name = $widget->name;

			$view->display = Language::get($widget->display ? 'WIDGET_DISPLAY_ACTIVE' : 'WIDGET_DISPLAY_DISABLED');
		}
	}
}
