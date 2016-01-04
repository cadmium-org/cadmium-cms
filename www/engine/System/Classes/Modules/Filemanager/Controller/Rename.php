<?php

namespace System\Modules\Filemanager\Controller {

	use System\Modules\Filemanager;

	class Rename {

		protected $entity = null;

		# Constructor

		public function __construct(Filemanager\Utils\Entity $entity) {

			$this->entity = $entity;
		}

		# Invoker

		public function __invoke(array $post) {

			# Declare variables

			$name = '';

			# Extract post array

			extract($post);

			# Validate name

			if (false === ($name = Filemanager\Validate::name($name))) return 'FILEMANAGER_ERROR_NAME_INVALID';

			# Check if item exists

			if ((0 !== strcasecmp($this->entity->name(), $name)) &&

				@file_exists($this->entity->parent()->pathFull() . $name)) return 'FILEMANAGER_ERROR_EXISTS';

			# Rename item

			if (!$this->entity->rename($name)) return (($this->entity->type() === FILEMANAGER_TYPE_DIR) ?

				'FILEMANAGER_ERROR_DIR_RENAME' : 'FILEMANAGER_ERROR_FILE_RENAME');

			# ------------------------

			return true;
		}
	}
}