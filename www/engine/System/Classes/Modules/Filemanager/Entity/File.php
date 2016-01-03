<?php

namespace System\Modules\Filemanager\Entity {

	use System\Modules\Filemanager;

	class File extends Filemanager\Utils\Entity {

		# Entity configuration

		protected static $type = FILEMANAGER_TYPE_FILE; 

		protected static $checker = 'isFile';

		protected static $creator = 'createFile';

		protected static $remover = 'removeFile';
	}
}
