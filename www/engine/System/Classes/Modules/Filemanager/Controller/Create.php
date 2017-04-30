<?php

/**
 * @package Cadmium\System\Modules\Filemanager
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Filemanager\Controller {

	use Modules\Filemanager, Utils\Validate;

	class Create {

		protected $parent = null;

		/**
		 * Constructor
		 */

		public function __construct(Filemanager\Utils\Container $parent) {

			$this->parent = $parent;
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

			# Get entity

			$entity = Filemanager::get($this->parent);

			# Check if name is used

			if (!$entity->check($name)) return ['name', 'FILEMANAGER_ERROR_EXISTS'];

			# Create entity

			if (!$entity->create($name, 'dir')) return 'FILEMANAGER_ERROR_DIR_CREATE';

			# ------------------------

			return true;
		}
	}
}
