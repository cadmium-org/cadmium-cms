<?php

/**
 * @package Cadmium\System\Utils
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Utils {

	use Utils\Messages, Utils\Popup, Explorer, Language, Request;

	abstract class Uploader {

		private static $base_name = null, $file_name = null;

		/**
		 * Convert a PHP upload error to a usable error code
		 */

		private static function getErrorCode(int $error) : string {

			if ($error === UPLOAD_ERR_INI_SIZE)         return 'UPLOADER_ERROR_INI_SIZE';

			if ($error === UPLOAD_ERR_FORM_SIZE)        return 'UPLOADER_ERROR_FORM_SIZE';

			if ($error === UPLOAD_ERR_PARTIAL)          return 'UPLOADER_ERROR_PARTIAL';

			if ($error === UPLOAD_ERR_NO_FILE)          return 'UPLOADER_ERROR_NO_FILE';

			if ($error === UPLOAD_ERR_NO_TMP_DIR)       return 'UPLOADER_ERROR_NO_TMP_DIR';

			if ($error === UPLOAD_ERR_CANT_WRITE)       return 'UPLOADER_ERROR_CANT_WRITE';

			if ($error === UPLOAD_ERR_EXTENSION)        return 'UPLOADER_ERROR_EXTENSION';

			# ------------------------

			return 'UPLOADER_ERROR_UNKNOWN';
		}

		/**
		 * Display an error message
		 *
		 * @return false : the method always returns false
		 */

		private static function displayError(string $phrase, bool $popup) : bool {

			$text = Language::get($phrase);

			if (!$popup) Messages::set('error', $text); else Popup::set('negative', $text);

			# ------------------------

			return false;
		}

		/**
		 * Save an uploaded file
		 *
		 * @return true|string|false : true on success, an error code on failure, or false if there are no uploaded files
		 */

		public static function save(string $name, string $dir_name) {

			if (false === ($file = Request::file($name))) return false;

			# Check for upload errors

			if ($file['error'] !== UPLOAD_ERR_OK) return self::getErrorCode($file['error']);

			# Check for secure upload

			if (!is_uploaded_file($file['tmp_name'])) return 'UPLOADER_ERROR_SECURITY';

			# Check size

			if ($file['size'] > CONFIG_UPLOADS_MAX_SIZE) return 'UPLOADER_ERROR_SIZE';

			# Check file extension

			$extensions = ['php', 'phtml', 'php3', 'php4', 'php5', 'phps'];

			$extension = strtolower(Explorer::getExtension($file['name'], false));

			if (in_array($extension, $extensions, true)) return 'UPLOADER_ERROR_TYPE';

			# Check target directory

			if (!Explorer::isDir($dir_name) && !Explorer::createDir($dir_name)) return 'UPLOADER_ERROR_DIR';

			# Check target file

			$base_name = basename($file['name']); $file_name = ($dir_name . '/' . $base_name);

			if (Explorer::isDir($file_name) || Explorer::isFile($file_name)) return 'UPLOADER_ERROR_EXISTS';

			# Save uploaded file

			if (!@move_uploaded_file($file['tmp_name'], $file_name)) return 'UPLOADER_ERROR_SAVE';

			# Set upload data

			self::$base_name = $base_name; self::$file_name = $file_name;

			# ------------------------

			return true;
		}

		/**
		 * Save an uploaded file and display an error if appeared
		 *
		 * @param $popup : tells to display a popup error message instead of a regular message
		 *
		 * @return bool : true on success or false on failure
		 */

		public static function handle(string $name, string $dir_name, bool $popup = false) : bool {

			$result = self::save($name, $dir_name);

			if (is_string($result)) return self::displayError($result, $popup);

			# ------------------------

			return $result;
		}

		/**
		 * Get a basename of a last successfully uploaded file
		 */

		public static function getBasename() : string {

			return self::$base_name;
		}

		/**
		 * Get a filename of a last successfully uploaded file
		 */

		public static function getFilename() : string {

			return self::$file_name;
		}
	}
}
