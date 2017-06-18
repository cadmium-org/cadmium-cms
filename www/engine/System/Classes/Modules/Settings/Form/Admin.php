<?php

/**
 * @package Cadmium\System\Modules\Settings
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Settings\Form {

	use Modules\Extend, Modules\Settings, Utils\Form, Utils\Range;

	class Admin extends Form {

		protected $name = 'settings';

		/**
		 * Constructor
		 */

		public function __construct() {

			# Admin language

			$languages = Extend\Languages::getLoader(SECTION_ADMIN);

			$this->addSelect('admin_language', $languages->get('name'), $languages->getItems(true));

			# Admin template

			$templates = Extend\Templates::getLoader(SECTION_ADMIN);

			$this->addSelect('admin_template', $templates->get('name'), $templates->getItems(true));

			# Admin display entities

			$this->addSelect('admin_display_entities', Settings::get('admin_display_entities'),

				Range\Display\Entities::getRange());

			# Admin display files

			$this->addSelect('admin_display_files', Settings::get('admin_display_files'),

				Range\Display\Files::getRange());
		}
	}
}
