<?php

namespace {

	abstract class Explorer {

		# Check if file exists

		public static function isFile($file_name) {

			$file_name = String::validate($file_name);

			return (@file_exists($file_name) && @is_file($file_name));
		}

		# Check if directory exists

		public static function isDir($dir_name) {

			$dir_name = String::validate($dir_name);

			return (@file_exists($dir_name) && @is_dir($dir_name));
		}

		# Get files list

		public static function listFiles($dir_name) {

			$dir_name = String::validate($dir_name);

			if (!self::isDir($dir_name)) return array();

			$files = array(); $handler = @opendir($dir_name);

			while (false !== ($name = readdir($handler))) {

				if ($name !== '.' && $name !== '..' && @is_file($dir_name . $name)) $files[] = $name;
			}

			closedir($handler);

			# ------------------------

			return $files;
		}

		# Get directories list

		public static function listDirs($dir_name) {

			$dir_name = String::validate($dir_name);

			if (!self::isDir($dir_name)) return array();

			$dirs = array(); $handler = @opendir($dir_name);

			while (false !== ($name = readdir($handler))) {

				if ($name !== '.' && $name !== '..' && @is_dir($dir_name . $name)) $dirs[] = $name;
			}

			closedir($handler);

			# ------------------------

			return $dirs;
		}

		# Get file dirname

		public static function dirname($file_name, $check_exists = true) {

			$file_name = String::validate($file_name); $check_exists = Validate::boolean($check_exists);

			if ($check_exists && !self::isFile($file_name)) return false;

			# ------------------------

			return pathinfo($file_name, PATHINFO_DIRNAME);
		}

		# Get file basename

		public static function basename($file_name, $check_exists = true) {

			$file_name = String::validate($file_name); $check_exists = Validate::boolean($check_exists);

			if ($check_exists && !self::isFile($file_name)) return false;

			# ------------------------

			return pathinfo($file_name, PATHINFO_BASENAME);
		}

		# Get file filename

		public static function filename($file_name, $check_exists = true) {

			$file_name = String::validate($file_name); $check_exists = Validate::boolean($check_exists);

			if ($check_exists && !self::isFile($file_name)) return false;

			# ------------------------

			return pathinfo($file_name, PATHINFO_FILENAME);
		}

		# Get file extension

		public static function extension($file_name, $check_exists = true) {

			$file_name = String::validate($file_name); $check_exists = Validate::boolean($check_exists);

			if ($check_exists && !self::isFile($file_name)) return false;

			# ------------------------

			return pathinfo($file_name, PATHINFO_EXTENSION);
		}

		# Get file contents

		public static function contents($file_name) {

			$file_name = String::validate($file_name); if (!self::isFile($file_name)) return false;

			return ((false !== ($contents = @file_get_contents($file_name))) ? $contents : false);
		}

		# Get PHP file data

		public static function php($file_name) {

			$file_name = String::validate($file_name); $extension = self::extension($file_name);

			if ((null === $extension) || (false === $extension) || strtolower($extension) !== 'php') return false;

			# ------------------------

			return include $file_name;
		}

		# Get JSON file data

		public static function json($file_name) {

			$file_name = String::validate($file_name); $extension = self::extension($file_name);

			if ((null === $extension) || (false === $extension) || strtolower($extension) !== 'json') return false;

			# ------------------------

			return json_decode(@file_get_contents($file_name), true);
		}

		# Get XML file data

		public static function xml($file_name) {

			$file_name = String::validate($file_name); $extension = self::extension($file_name);

			if ((null === $extension) || (false === $extension) || strtolower($extension) !== 'xml') return false;

			# ------------------------

			return @simplexml_load_file($file_name);
		}

		# Save data to file

		public static function save($file_name, $contents, $force = false) {

			$file_name = String::validate($file_name); $contents = String::validate($contents);

			$force = Validate::boolean($force);

			if (self::isFile($file_name)) if (!$force) return false; else if (!@unlink($file_name)) return false;

			# ------------------------

			return file_put_contents($file_name, $contents);
		}
	}
}
