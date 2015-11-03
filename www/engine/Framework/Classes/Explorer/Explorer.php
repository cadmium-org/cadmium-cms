<?php

namespace {

	abstract class Explorer {

		# Get list of directory items

		private static function getList($dir_name, $dirs = false) {

			$dir_name = strval($dir_name);

			if (false === ($handler = @opendir($dir_name))) return [];

			$list = [];

			while (false !== ($name = readdir($handler))) {

				if (($name === '.') || ($name === '..')) continue;

				if ($dirs ? @is_dir($dir_name . $name) : @is_file($dir_name . $name)) $list[] = $name;
			}

			closedir($handler);

			# ------------------------

			return $list;
		}

		# Get file info

		private static function getInfo($file_name, $param, $check_exists = true) {

			$file_name = strval($file_name); $check_exists = boolval($check_exists);

			if ($check_exists && !self::isFile($file_name)) return false;

			# ------------------------

			return pathinfo($file_name, $param);
		}

		# Check if file exists

		public static function isFile($file_name) {

			$file_name = strval($file_name);

			return (@file_exists($file_name) && @is_file($file_name));
		}

		# Check if directory exists

		public static function isDir($dir_name) {

			$dir_name = strval($dir_name);

			return (@file_exists($dir_name) && @is_dir($dir_name));
		}

		# Remove file

		public static function removeFile($file_name) {

			$file_name = strval($file_name);

			return @unlink($file_name);
		}

		# Remove directory

		public static function removeDir($dir_name, $recursive = false) {

			$dir_name = strval($dir_name); $recursive = boolval($recursive);

			if ($recursive && (false !== ($list = @scandir($dir_name)))) {

				foreach (array_diff($list, ['.', '..']) as $name) {

					$name = ($dir_name . '/' . $name);

					if (@is_dir($name)) self::removeDir($name, true);

					else if (@is_file($name)) self::removeFile($name);
				}
			}

			# ------------------------

			return @rmdir($dir_name);
		}

		# Get files list

		public static function listFiles($dir_name) {

			return self::getList($dir_name, false);
		}

		# Get directories list

		public static function listDirs($dir_name) {

			return self::getList($dir_name, true);
		}

		# Get file dirname

		public static function dirname($file_name, $check_exists = true) {

			return self::getInfo($file_name, PATHINFO_DIRNAME, $check_exists);
		}

		# Get file basename

		public static function basename($file_name, $check_exists = true) {

			return self::getInfo($file_name, PATHINFO_BASENAME, $check_exists);
		}

		# Get file filename

		public static function filename($file_name, $check_exists = true) {

			return self::getInfo($file_name, PATHINFO_FILENAME, $check_exists);
		}

		# Get file extension

		public static function extension($file_name, $check_exists = true) {

			return self::getInfo($file_name, PATHINFO_EXTENSION, $check_exists);
		}

		# Get file contents

		public static function contents($file_name) {

			$file_name = strval($file_name);

			return ((false !== ($contents = @file_get_contents($file_name))) ? $contents : false);
		}

		# Get PHP file data

		public static function php($file_name) {

			if ((strtolower(self::extension($file_name)) !== 'php')) return false;

			return include $file_name;
		}

		# Get XML file data

		public static function xml($file_name) {

			if ((strtolower(self::extension($file_name)) !== 'xml')) return false;

			return @simplexml_load_file($file_name);
		}

		# Get JSON file data

		public static function json($file_name) {

			if ((strtolower(self::extension($file_name)) !== 'json')) return false;

			return json_decode(@file_get_contents($file_name), true);
		}

		# Save data to file

		public static function save($file_name, $contents, $force = false) {

			$file_name = strval($file_name); $contents = strval($contents); $force = boolval($force);

			if (self::isFile($file_name)) if (!$force) return false; else if (!@unlink($file_name)) return false;

			# ------------------------

			return file_put_contents($file_name, $contents);
		}
	}
}
