<?php

/**
 * @package Cadmium\System\Modules\Filemanager
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Filemanager\Form {

	use Modules\Filemanager, Utils\Form, Language;

	class Edit extends Form {

		protected $name = 'edit';

		/**
		 * Constructor
		 */

		public function __construct(Filemanager\Utils\Entity $entity, bool $enabled = true) {

			$this->addText('contents', $entity->getContents(), FORM_FIELD_TEXTAREA, 0,

				['multiline' => true, 'codestyle' => true, 'disabled' => !$enabled]);
		}
	}
}
