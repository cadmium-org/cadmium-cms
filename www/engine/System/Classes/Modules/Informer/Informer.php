<?php

namespace Modules {

	use DB, Explorer;

	abstract class Informer {

		# Count table entries

		public static function countEntries(string $table, bool $false_on_error = false) {

			if (!(DB::select($table, 'COUNT(id) as count') && (DB::getLast()->rows === 1))) {

				return (!$false_on_error ? 0 : false);
			}

			# ------------------------

			return intval(DB::getLast()->getRow()['count']);
		}

		# Check if install file exists

		public static function checkInstallFile() {

			return Explorer::isFile(DIR_WWW . 'install.php');
		}

		# Get MySQL version

		public static function mysqlVersion() {

			if (!(DB::send("SELECT VERSION() as version") && DB::getLast()->status)) return false;

			return strval(DB::getLast()->getRow()['version']);
		}
	}
}
