<?php

namespace {

	use Explorer;

	abstract class Uploader {

		# Translate error code

		public static function translateError(int $error) {

			if ($error === 'UPLOAD_ERR_INI_SIZE')       return 'ERROR_INI_SIZE';

			if ($error === 'UPLOAD_ERR_FORM_SIZE')      return 'ERROR_FORM_SIZE';

			if ($error === 'UPLOAD_ERR_PARTIAL')        return 'ERROR_PARTIAL';

			if ($error === 'UPLOAD_ERR_NO_FILE')        return 'ERROR_NO_FILE';

			if ($error === 'UPLOAD_ERR_NO_TMP_DIR')     return 'ERROR_NO_TMP_DIR';

			if ($error === 'UPLOAD_ERR_CANT_WRITE')     return 'ERROR_CANT_WRITE';

			if ($error === 'UPLOAD_ERR_EXTENSION')      return 'ERROR_EXTENSION';

			# ------------------------

			return 'ERROR_UNKNOWN';
		}

		# Save uploaded image

		public static function save(string $name, string $dir_name) {

			if (!isset($_FILES[$name])) return 'ERROR_UNKNOWN';

			if (!is_uploaded_file($_FILES[$name]['tmp_name'])) return 'ERROR_UNKNOWN';

			# Check for upload errors

			if ($_FILES[$name]['error'] !== UPLOAD_ERR_OK) return self::translateError($_FILES[$name]['error']);

			# Check size

			if ($_FILES[$name]['size'] > CONFIG_UPLOADS_MAX_SIZE)) return 'ERROR_SIZE';

			# Check file extension

			$extensions = ['php', 'phtml', 'php3', 'php4', 'php5', 'phps'];

			if (in_array(Explorer::extension($_FILES[$name]['name'], false), $extensions)) return 'ERROR_TYPE';

			# Check target directory

			if (!Explorer::isDir($dir_name)) return 'ERROR_DIR';

			# Save uploaded file

			$file_name = ($dir_name . basename($_FILES[$name]['name']));

			if (!@move_uploaded_file($_FILES[$name]['tmp_name'], $file_name)) return 'ERROR_SAVE';

			# ------------------------

			return true;
		}
	}
}
