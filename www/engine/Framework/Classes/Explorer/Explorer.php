<?php

/**
 * @package Cadmium\Framework\Explorer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace {

	abstract class Explorer {

		/**
		 * Get list of directory items
		 */

		private static function getList(string $dir_name, string $type = null) : Generator {

			if (false !== ($handler = @opendir($dir_name))) {

				while (false !== ($name = readdir($handler))) {

					if (($name === '.') || ($name === '..')) continue;

					if ((null === $type) || (@filetype($dir_name . $name) === $type)) yield $name;
				}

				closedir($handler);
			}
		}

		/**
		 * Get information about a file
		 *
		 * @return string|false : the string or false if $check_exists is true and the file does not actually exists
		 */

		private static function getInfo(string $file_name, int $param, bool $check_exists = true) {

			if ($check_exists && !self::isFile($file_name)) return false;

			return pathinfo($file_name, $param);
		}

		/**
		 * Check if a file (or a directory) exists
		 */

		public static function exists(string $file_name) : bool {

			return @file_exists($file_name);
		}

		/**
		 * Check if a directory exists
		 */

		public static function isDir(string $dir_name) : bool {

			return (@file_exists($dir_name) && @is_dir($dir_name));
		}

		/**
		 * Check if a file exists
		 */

		public static function isFile(string $file_name) : bool {

			return (@file_exists($file_name) && @is_file($file_name));
		}

		/**
		 * Create a directory
		 *
		 * @return bool : true on success or false on failure
		 */

		public static function createDir(string $dir_name, int $mode = 0755) : bool {

			return @mkdir($dir_name, $mode, true);
		}

		/**
		 * Create a file
		 *
		 * @return bool : true on success or false on failure
		 */

		public static function createFile(string $file_name) : bool {

			return @touch($file_name);
		}

		/**
		 * Rename a file (or a directory)
		 *
		 * @return bool : true on success or false on failure
		 */

		 public static function rename(string $file_name, string $new_file_name) {

			 return @rename($file_name, $new_file_name);
		 }

		/**
		 * Remove a directory
		 *
		 * @return bool : true on success or false on failure
		 */

		public static function removeDir(string $dir_name, bool $recursive = false) : bool {

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

		/**
		 * Remove a file
		 *
		 * @return bool : true on success or false on failure
		 */

		public static function removeFile(string $file_name) : bool {

			return @unlink($file_name);
		}

		/**
		 * Iterate over files and directories within a given directory
		 */

		public static function iterate(string $dir_name) : Generator {

 			foreach (self::getList($dir_name) as $name) yield $name;
 		}

		/**
		 * Iterate over directories within a given directory
		 */

		public static function iterateDirs(string $dir_name) : Generator {

			foreach (self::getList($dir_name, 'dir') as $name) yield $name;
		}

		/**
		 * Iterate over files within a given directory
		 */

		public static function iterateFiles(string $dir_name) : Generator {

			foreach (self::getList($dir_name, 'file') as $name) yield $name;
		}

		/**
		 * Get a list of files and directories within a given directory
		 */

		public static function list(string $dir_name) : array {

			return iterator_to_array(self::getList($dir_name));
		}

		/**
		 * Get a list of directories within a given directory
		 */

		public static function listDirs(string $dir_name) : array {

			return iterator_to_array(self::getList($dir_name, 'dir'));
		}

		/**
		 * Get a list of files within a given directory
		 */

		public static function listFiles(string $dir_name) : array {

			return iterator_to_array(self::getList($dir_name, 'file'));
		}

		/**
		 * Get a parent directory name
		 *
		 * @return string|false : the name or false if $check_exists is true and the file does not actually exists
		 */

		public static function getDirname(string $file_name, bool $check_exists = true) {

			return self::getInfo($file_name, PATHINFO_DIRNAME, $check_exists);
		}

		/**
		 * Get a basename of a file
		 *
		 * @return string|false : the basename or false if $check_exists is true and the file does not actually exists
		 */

		public static function getBasename(string $file_name, bool $check_exists = true) {

			return self::getInfo($file_name, PATHINFO_BASENAME, $check_exists);
		}

		/**
		 * Get a filename of a file
		 *
		 * @return string|false : the filename or false if $check_exists is true and the file does not actually exists
		 */

		public static function getFilename(string $file_name, bool $check_exists = true) {

			return self::getInfo($file_name, PATHINFO_FILENAME, $check_exists);
		}

		/**
		 * Get an extnesion of a file
		 *
		 * @return string|false : the extension or false if $check_exists is true and the file does not actually exists
		 */

		public static function getExtension(string $file_name, bool $check_exists = true) {

			return self::getInfo($file_name, PATHINFO_EXTENSION, $check_exists);
		}

		/**
		 * Get a file type
		 *
		 * @return string|false : one of the following values: 'dir', 'file', 'fifo', 'char', 'block', 'link', 'socket', 'unknown',
		 *         or false on failure
		 */

		public static function getType(string $file_name) {

			return @filetype($file_name);
		}

		/**
		 * Get a file (or a directory) creation time
		 *
		 * @return int|false : the time or false on failure
		 */

		public static function getCreated(string $file_name) {

			return @filectime($file_name);
		}

		/**
		 * Get a file (or a directory) access time
		 *
		 * @return int|false : the time or false on failure
		 */

		public static function getAccessed(string $file_name) {

			return @fileatime($file_name);
		}

		/**
		 * Get a file (or a directory) modification time
		 *
		 * @return int|false : the time or false on failure
		 */

		public static function getModified(string $file_name) {

			return @filemtime($file_name);
		}

		/**
		 * Get a file (or a directory) permissions
		 *
		 * @return int|false : the permissions or false on failure
		 */

		public static function getPermissions(string $file_name) {

			return @fileperms($file_name);
		}

		/**
		 * Get a file (or a directory) size
		 *
		 * @return int|false : the size or false on failure
		 */

		public static function getSize(string $file_name) {

			return @filesize($file_name);
		}

		/**
		 * Get file contents
		 *
		 * @return string|false : the read data or false on failure
		 */

		public static function getContents(string $file_name) {

			return @file_get_contents($file_name);
		}

		/**
		 * Save data into a file
		 *
		 * @return int|false : the number of bytes that were written to the file or false on failure
		 */

		public static function putContents(string $file_name, string $contents) {

			return @file_put_contents($file_name, $contents);
		}

		/**
		 * Include a PHP file
		 *
		 * @return mixed|false : the file return data or false on failure
		 */

		public static function include(string $file_name) {

			if ((strtolower(self::getExtension($file_name)) !== 'php')) return false;

			return @include $file_name;
		}
	}
}
