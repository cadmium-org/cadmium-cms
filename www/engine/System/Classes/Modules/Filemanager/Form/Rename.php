<?php

/**
 * @package Cadmium\System\Modules\Filemanager
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Filemanager\Form {

	use Modules\Filemanager, Utils\Form, Language;

	class Rename extends Form {

		protected $name = 'rename';

		/**
		 * Constructor
		 */

		public function __construct(Filemanager\Utils\Entity $entity, bool $enabled = true) {

			$this->addText('name', $entity->getName(), FORM_FIELD_TEXT, CONFIG_FILEMANAGER_NAME_MAX_LENGTH,

				['placeholder' => Language::get('FILEMANAGER_FIELD_NAME'), 'required' => true, 'disabled' => !$enabled]);
		}
	}
}
