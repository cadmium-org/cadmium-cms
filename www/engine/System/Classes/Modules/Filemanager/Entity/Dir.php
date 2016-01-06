<?php

namespace Modules\Filemanager\Entity {

	use Modules\Filemanager;

	class Dir extends Filemanager\Utils\Entity {

		# Entity configuration

		protected static $type = FILEMANAGER_TYPE_DIR;

		protected static $checker = 'isDir';

		protected static $creator = 'createDir';

		protected static $remover = 'removeDir';
	}
}
