<?php

/**
 * @package Cadmium\System\Modules\Filemanager
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Filemanager\Handler {

	use Frames, Utils\Uploader, Ajax, Language, Request;

	class Upload extends Frames\Admin\Area\Panel {

		/**
		 * Handle the request
		 *
		 * @return Ajax\Response|false : an ajax response if the ajax param was set to true, otherwise false
		 */

		protected function handle(bool $ajax = false) {

			if (!$ajax) return false;

			# Create response

			$ajax = Ajax::createResponse();

			# Get target directory

			$target_dir = ((Request::get('type') === 'image') ? 'data/images/' : 'data/');

			# Save uploaded file

			if (true === ($upload = (Uploader::save('upload', (DIR_UPLOADS . $target_dir))))) {

				$name = Uploader::getBasename(); $url = (INSTALL_PATH . '/uploads/' . $target_dir . $name);

				$ajax->set('name', $name)->set('url', $url);

			} else {

				$ajax->setError(Language::get((false !== $upload) ? $upload : 'UPLOADER_ERROR_UNKNOWN'));
			}

			# ------------------------

			return $ajax;
		}
	}
}
