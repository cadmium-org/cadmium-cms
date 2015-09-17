<?php

namespace System\Modules {

    use DB, Explorer;

	abstract class Informer {

        # Check if install file exists

        public static function checkInstallFile() {

            return Explorer::isFile(DIR_WWW . 'install.php');
        }

        # Get MySQL version

		public static function mysqlVersion() {

			if (!(DB::send("SELECT VERSION() as version") && DB::last()->status)) return false;

			return strval(DB::last()->row()['version']);
		}

		# Get pages count

		public static function countPages() {

			if (!(DB::select(TABLE_PAGES, 'COUNT(id) as count') && (DB::last()->rows === 1))) return 0;

			return intabs(DB::last()->row()['count']);
		}

		# Get users count

		public static function countUsers() {

			if (!(DB::select(TABLE_USERS, 'COUNT(id) as count') && (DB::last()->rows === 1))) return 0;

			return intabs(DB::last()->row()['count']);
		}
	}
}
