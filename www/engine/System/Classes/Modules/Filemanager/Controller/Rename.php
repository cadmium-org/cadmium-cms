<?php

/**
 * @package Cadmium\System\Modules\Filemanager
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Filemanager\Controller {

	use Modules\Filemanager, Utils\Validate;

	class Rename {

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

			$name = '';

			# Extract post array

			extract($post);

			# Validate name

			if (false === ($name = Validate::fileName($name))) return ['name', 'FILEMANAGER_ERROR_NAME_INVALID'];

			if ($this->parent->isIgnoreHidden() && preg_match('/^\./', $name)) return ['name', 'FILEMANAGER_ERROR_HIDDEN'];

			# Check if name is used

			if (!$this->entity->check($name)) return ['name', 'FILEMANAGER_ERROR_EXISTS'];

			# Rename entity

			if (!$this->entity->rename($name)) return (($this->entity->getType() === 'dir') ?

				'FILEMANAGER_ERROR_DIR_RENAME' : 'FILEMANAGER_ERROR_FILE_RENAME');

			# ------------------------

			return true;
		}
	}
}
