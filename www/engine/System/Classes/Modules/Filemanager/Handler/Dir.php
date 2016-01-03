<?php

namespace System\Modules\Filemanager\Handler {

	use System\Modules\Filemanager, Date, Template;

	class Dir extends Filemanager\Utils\Handler {

		# Handler configuration

		protected static $type = FILEMANAGER_TYPE_DIR;

		protected static $message_success_rename = 'FILEMANAGER_SUCCESS_DIR_RENAME';

		protected static $message_error_remove = 'FILEMANAGER_ERROR_DIR_REMOVE';

		protected static $view = 'Blocks\Filemanager\Dir';

		# Set item info

		protected function processInfo(Template\Asset\Block $info) {

			# Set times

			$info->time_created = Date::get(DATE_FORMAT_DATETIME, @filectime($this->entity->pathFull()));

			$info->time_modified = Date::get(DATE_FORMAT_DATETIME, @filemtime($this->entity->pathFull()));

			# Set permissions

			$info->permissions = @fileperms($this->entity->pathFull());
		}
	}
}
