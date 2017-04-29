<?php

/**
 * @package Cadmium\System\Modules\Filemanager
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Filemanager\Utils {

	abstract class Mime extends \Mime {

		/**
		 * Get an editor mode
		 *
		 * @return string|false : one of the following values: 'php', 'html', 'javascript', 'json', 'css',
		 *         or false if the extension is not supported by the editor
		 */

		public static function getMode(string $extension) {

			$modes = ['php' => 'php', 'html' => 'html', 'tpl' => 'html', 'js' => 'javascript', 'json' => 'json', 'css' => 'css'];

			return ($modes[$extension] ?? false);
		}

		/**
		 * Get a file format
		 *
		 * @return string|false : one of the following values: 'image', 'audio', 'video', 'word', 'excel', 'powerpoint', 'pdf',
		 *         or false if the extension does not exist in the MIME types list
		 */

		public static function getFormat(string $extension) {

			if (self::isImage($extension)) return 'image';

			if (self::isAudio($extension)) return 'audio';

			if (self::isVideo($extension)) return 'video';

			if (in_array($extension, ['doc', 'docx'], true)) return 'word';

			if (in_array($extension, ['xls', 'xlsx'], true)) return 'excel';

			if (in_array($extension, ['ppt', 'pptx'], true)) return 'powerpoint';

			if ($extension === 'pdf') return 'pdf';

			# ------------------------

			return false;
		}
	}
}
