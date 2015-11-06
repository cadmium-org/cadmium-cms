<?php

namespace {

	abstract class Explorer {

		# Get list of directory items

		private static function getList(string $dir_name, bool $dirs = false) {

			if (false === ($handler = @opendir($dir_name))) return [];

			while (false !== ($name = readdir($handler))) {

				if (($name === '.') || ($name === '..')) continue;

				if ($dirs ? @is_dir($dir_name . $name) : @is_file($dir_name . $name)) yield $name;
			}

			closedir($handler);
		}

		# Get file info

		private static function getInfo(string $file_name, int $param, bool $check_exists = true) {

			if ($check_exists && !self::isFile($file_name)) return false;

			return pathinfo($file_name, $param);
		}

		# Check if file exists

		public static function isFile(string $file_name) {

			return (@file_exists($file_name) && @is_file($file_name));
		}

		# Check if directory exists

		public static function isDir(string $dir_name) {

			return (@file_exists($dir_name) && @is_dir($dir_name));
		}

		# Remove file

		public static function removeFile(string $file_name) {

			return @unlink($file_name);
		}

		# Remove directory

		public static function removeDir(string $dir_name, bool $recursive = false) {

			if ($recursive && (false !== ($list = @scandir($dir_name)))) {

				foreach (array_diff($list, ['.', '..']) as $name) {

					$name = ($dir_name . '/' . $name);

					if (@is_file($name)) self::removeFile($name);

					else if (@is_dir($name)) self::removeDir($name, true);
				}
			}

			# ------------------------

			return @rmdir($dir_name);
		}

		# Get files list

		public static function listFiles(string $dir_name) {

			return self::getList($dir_name, false);
		}

		# Get directories list

		public static function listDirs(string $dir_name) {

			return self::getList($dir_name, true);
		}

		# Get file dirname

		public static function dirname(string $file_name, bool $check_exists = true) {

			return self::getInfo($file_name, PATHINFO_DIRNAME, $check_exists);
		}

		# Get file basename

		public static function basename(string $file_name, bool $check_exists = true) {

			return self::getInfo($file_name, PATHINFO_BASENAME, $check_exists);
		}

		# Get file filename

		public static function filename(string $file_name, bool $check_exists = true) {

			return self::getInfo($file_name, PATHINFO_FILENAME, $check_exists);
		}

		# Get file extension

		public static function extension(string $file_name, bool $check_exists = true) {

			return self::getInfo($file_name, PATHINFO_EXTENSION, $check_exists);
		}

		# Get file contents

		public static function contents(string $file_name) {

			return @file_get_contents($file_name);
		}

		# Get PHP file data

		public static function php(string $file_name) {

			if ((strtolower(self::extension($file_name)) !== 'php')) return false;

			return include $file_name;
		}

		# Get XML file data

		public static function xml(string $file_name) {

			if ((strtolower(self::extension($file_name)) !== 'xml')) return false;

			return @simplexml_load_file($file_name);
		}

		# Get JSON file data

		public static function json(string $file_name) {

			if ((strtolower(self::extension($file_name)) !== 'json')) return false;

			return json_decode(@file_get_contents($file_name), true);
		}

		# Save data to file

		public static function save(string $file_name, string $contents, bool $force = false) {

			if (self::isFile($file_name)) if (!$force) return false; else if (!@unlink($file_name)) return false;

			return @file_put_contents($file_name, $contents);
		}
	}
}
