<?php

/**
 * @package Cadmium\System\Modules\Filemanager
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Filemanager\Handler {

	use Modules\Filemanager, Date, Number, Template;

	abstract class File extends Filemanager\Utils\Handler {

		protected $_title = 'TITLE_CONTENT_FILEMANAGER_FILE';

		# Handler configuration

		protected static $type = 'file';

		protected static $view = 'Blocks/Filemanager/File';

		protected static $message_success_rename = 'FILEMANAGER_SUCCESS_FILE_RENAME';

		protected static $message_success_edit = 'FILEMANAGER_SUCCESS_FILE_EDIT';

		protected static $message_error_remove = 'FILEMANAGER_ERROR_FILE_REMOVE';

		/**
		 * Process the info block
		 */

		protected function processInfo(Template\Block $info) {

			# Set size

			$info->size = Number::size($this->entity->getSize());

			# Set MIME type

			$info->mime = (Filemanager\Utils\Mime::get($this->entity->getExtension()) ?: '-');

			# Set times

			$info->time_created = Date::get(DATE_FORMAT_DATETIME, $this->entity->getCreated());

			$info->time_modified = Date::get(DATE_FORMAT_DATETIME, $this->entity->getModified());

			# Set permissions

			$info->permissions = $this->entity->getPermissions();
		}
	}
}
