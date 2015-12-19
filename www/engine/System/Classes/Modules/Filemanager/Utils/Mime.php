<?php

namespace System\Modules\Filemanager\Utils {

	use Explorer;

	abstract class Mime extends \Mime {

		# Get file type by name

		public static function type(string $file_name) {

			$extension = strtolower(Explorer::extension($file_name, false));

			if (self::isImage($extension)) return 'image';

			if (self::isAudio($extension)) return 'audio';

			if (self::isVideo($extension)) return 'video';

			if (in_array($extension, ['doc', 'docx'], true)) return 'word';

			if (in_array($extension, ['xls', 'xlsx'], true)) return 'excel';

			if (in_array($extension, ['ppt', 'pptx'], true)) return 'powerpoint';

			if ($extension === 'pdf') return 'pdf';

			# ------------------------

			return '';
		}
	}
}
