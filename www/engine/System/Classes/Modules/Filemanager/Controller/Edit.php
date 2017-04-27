<?php

/**
 * @package Cadmium\System\Modules\Filemanager
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Filemanager\Controller {

	use Modules\Filemanager;

	class Edit {

		protected $parent = null, $entity = null;

		/**
		 * Constructor
		 */

		public function __construct(Filemanager\Utils\Entity $entity) {

			$this->parent = $entity->getParent(); $this->entity = $entity;
		}

		/**
		 * Invoker
		 *
		 * @return true|string|array : true on success, otherwise an error code, or an array of type [$param_name, $error_code],
		 *         where $param_name is a name of param that has triggered the error,
		 *         and $error_code is a language phrase related to the error
		 */

		public function __invoke(array $post) {

			# Declare variables

			$contents = '';

			# Extract post array

			extract($post);

			# Rename item

			if (false === $this->entity->putContents($contents)) return 'FILEMANAGER_ERROR_FILE_EDIT';

			# ------------------------

			return true;
		}
	}
}
