<?php

namespace Modules\Filemanager\Handler {

	use Modules\Filemanager, Date, Explorer, Mime, Number, Template;

	class File extends Filemanager\Utils\Handler {

		# Handler configuration

		protected static $type = FILEMANAGER_TYPE_FILE;

		protected static $message_success_rename = 'FILEMANAGER_SUCCESS_FILE_RENAME';

		protected static $message_error_remove = 'FILEMANAGER_ERROR_FILE_REMOVE';

		protected static $view = 'Blocks\Filemanager\File';

		# Set item info

		protected function processInfo(Template\Asset\Block $info) {

			# Set times

			$info->time_created = Date::get(DATE_FORMAT_DATETIME, @filectime($this->entity->pathFull()));

			$info->time_modified = Date::get(DATE_FORMAT_DATETIME, @filemtime($this->entity->pathFull()));

			# Set permissions

			$info->permissions = @fileperms($this->entity->pathFull());

			# Set size

			$info->size = Number::size(@filesize($this->entity->pathFull()));

			# Set MIME type

			$mime = Mime::get(strtolower(Explorer::extension($this->entity->name(), false)));

			$info->mime = ((false !== $mime) ? $mime : '-');
		}
	}
}
