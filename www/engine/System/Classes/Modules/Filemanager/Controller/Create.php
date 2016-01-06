<?php

namespace Modules\Filemanager\Controller {

	use Modules\Filemanager, Modules\Informer;

	class Create {

		protected $parent = null;

		# Constructor

		public function __construct(Filemanager\Utils\Container $parent) {

			$this->parent = $parent;
		}

		# Invoker

		public function __invoke(array $post) {

			# Declare variables

			$type = ''; $name = '';

			# Extract post array

			extract($post);

			# Check for demo mode

			if (Informer::isDemoMode()) return 'DEMO_MODE_RESTRICTION';

			# Validate name

			if (false === ($name = Filemanager\Validate::name($name))) return 'FILEMANAGER_ERROR_NAME_INVALID';

			# Check if item exists

			if (@file_exists($this->parent->pathFull() . $name)) return 'FILEMANAGER_ERROR_EXISTS';

			# Create item

			$entity = Filemanager::get($type, $this->parent);

			if (!$entity->create($name)) return (($entity->type() === FILEMANAGER_TYPE_DIR) ?

				'FILEMANAGER_ERROR_DIR_CREATE' : 'FILEMANAGER_ERROR_FILE_CREATE');

			# ------------------------

			return true;
		}
	}
}
