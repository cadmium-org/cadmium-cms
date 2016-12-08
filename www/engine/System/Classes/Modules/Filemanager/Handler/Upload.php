<?php

namespace Modules\Filemanager\Handler {

	use Frames, Utils\Uploader, Ajax, Language, Request;

	class Upload extends Frames\Admin\Area\Authorized {

		# Handle request

		protected function handle() {

			if (!Request::isAjax()) return false;

			# Create response

			$ajax = Ajax::createResponse();

			# Get target directory

			$target_dir = ((Request::get('type') === 'image') ? 'data/images/' : 'data/');

			# Save uploaded file

			if (true === ($upload = (Uploader::save('upload', (DIR_UPLOADS . $target_dir))))) {

				$base_name = Uploader::baseName(); $url = (INSTALL_PATH . '/uploads/' . $target_dir . $base_name);

				$ajax->set('uploaded', 1)->set('fileName', $base_name)->set('url', $url);

			} else {

				$message = Language::get((false !== $upload) ? $upload : 'UPLOADER_ERROR_UNKNOWN');

				$ajax->set('uploaded', 0)->setError(['message' => $message]);
			}

			# ------------------------

			return $ajax;
		}
	}
}
