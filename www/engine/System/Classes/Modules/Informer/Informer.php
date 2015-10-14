<?php

namespace System\Modules {

	use DB, Explorer;

	abstract class Informer {

		# Count table entries

		private static function countEntries($table_name, $false_on_error = false) {

			if (!(DB::select($table_name, 'COUNT(id) as count') && (DB::last()->rows === 1))) {

				return (!$false_on_error ? 0 : false);
			}

			# ------------------------

			return intabs(DB::last()->row()['count']);
		}

		# Check if install file exists

		public static function checkInstallFile() {

			return Explorer::isFile(DIR_WWW . 'install.php');
		}

		# Check if debug mode forced

		public static function isDebugMode() {

			return Explorer::isFile(DIR_SYSTEM_DATA . '.debug');
		}

		# Check if demo mode forced

		public static function isDemoMode() {

			return Explorer::isFile(DIR_SYSTEM_DATA . '.demo');
		}

		# Get MySQL version

		public static function mysqlVersion() {

			if (!(DB::send("SELECT VERSION() as version") && DB::last()->status)) return false;

			return strval(DB::last()->row()['version']);
		}

		# Get pages count

		public static function countPages($false_on_error = false) {

			$false_on_error = boolval($false_on_error);

			return self::countEntries(TABLE_PAGES, $false_on_error);
		}

		# Get users count

		public static function countUsers($false_on_error = false) {

			$false_on_error = boolval($false_on_error);

			return self::countEntries(TABLE_USERS, $false_on_error);
		}
	}
}
