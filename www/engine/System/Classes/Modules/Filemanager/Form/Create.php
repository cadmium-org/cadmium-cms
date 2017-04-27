<?php

/**
 * @package Cadmium\System\Modules\Filemanager
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Filemanager\Form {

	use Utils\Form, Language;

	class Create extends Form {

		protected $name = 'create';

		/**
		 * Constructor
		 */

		public function __construct() {

			$this->addText('name', '', FORM_FIELD_TEXT, CONFIG_FILEMANAGER_NAME_MAX_LENGTH,

				['placeholder' => Language::get('FILEMANAGER_LABEL_CREATE'), 'required' => true]);
		}
	}
}
