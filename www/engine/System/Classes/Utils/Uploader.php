<?php

namespace System\Utils {

	use System\Utils\Messages, Explorer, Language, Request;

	abstract class Uploader {

		# Translate error code

		private static function translateError(int $error) {

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

		# Save uploaded file

		public static function save(string $name, string $dir_name) {

			if ((false === ($file = Request::file($name))) || !is_uploaded_file($file['tmp_name'])) return false;

			# Check for upload errors

			if ($file['error'] !== UPLOAD_ERR_OK) return self::translateError($file['error']);

			# Check size

			if ($file['size'] > CONFIG_UPLOADS_MAX_SIZE) return 'UPLOADER_ERROR_SIZE';

			# Check file extension

			$extensions = ['php', 'phtml', 'php3', 'php4', 'php5', 'phps'];

			if (in_array(Explorer::extension($file['name'], false), $extensions)) return 'UPLOADER_ERROR_TYPE';

			# Check target directory

			if (!Explorer::isDir($dir_name)) return 'UPLOADER_ERROR_DIR';

			# Check target file

			$file_name = ($dir_name . '/' . basename($file['name']));

			if (Explorer::isDir($file_name) || Explorer::isFile($file_name)) return 'UPLOADER_ERROR_EXISTS';

			# Save uploaded file

			if (!@move_uploaded_file($file['tmp_name'], $file_name)) return 'UPLOADER_ERROR_SAVE';

			# ------------------------

			return true;
		}

		# Submit uploaded file

		public static function submit(string $name, string $dir_name) {

			$result = self::save($name, $dir_name);

			if (is_string($result)) { Messages::error(Language::get($result)); return false; }

			# ------------------------

			return (true === $result);
		}
	}
}
