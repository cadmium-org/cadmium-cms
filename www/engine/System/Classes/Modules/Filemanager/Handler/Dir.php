<?php

/**
 * @package Cadmium\System\Modules\Filemanager
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Filemanager\Handler {

	use Modules\Filemanager, Date, Template;

	abstract class Dir extends Filemanager\Utils\Handler {

		protected $_title = 'TITLE_CONTENT_FILEMANAGER_DIR';

		# Handler configuration

		protected static $type = 'dir';

		protected static $view = 'Blocks/Filemanager/Dir';

		protected static $message_success_rename = 'FILEMANAGER_SUCCESS_DIR_RENAME';

		protected static $message_success_edit = '';

		protected static $message_error_remove = 'FILEMANAGER_ERROR_DIR_REMOVE';

		/**
		 * Process the info block
		 */

		protected function processInfo(Template\Block $info) {

			# Set times

			$info->time_created = Date::get(DATE_FORMAT_DATETIME, $this->entity->getCreated());

			$info->time_modified = Date::get(DATE_FORMAT_DATETIME, $this->entity->getModified());

			# Set permissions

			$info->permissions = $this->entity->getPermissions();
		}
	}
}
