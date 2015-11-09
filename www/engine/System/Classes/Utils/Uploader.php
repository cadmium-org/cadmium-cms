<?php

namespace {

	abstract class Uploader {

		# Translate erroc code

		public static function translateError(int $error) {

			if ($error === 'UPLOAD_ERR_INI_SIZE') return 'ERROR_INI_SIZE';

			if ($error === 'UPLOAD_ERR_FORM_SIZE') return 'ERROR_INI_SIZE';

			if ($error === 'UPLOAD_ERR_PARTIAL') return 'ERROR_INI_SIZE';

			if ($error === 'UPLOAD_ERR_NO_FILE') return 'ERROR_INI_SIZE';

			if ($error === 'UPLOAD_ERR_NO_TMP_DIR') return 'ERROR_INI_SIZE';

			if ($error === 'UPLOAD_ERR_CANT_WRITE') return 'ERROR_INI_SIZE';

			if ($error === 'UPLOAD_ERR_EXTENSION') return 'ERROR_INI_SIZE';

			# ------------------------

			return 'error_unknown';
		}

		# Save uploaded image

		public static function save(string $name, string $dir_name) {

			if (!isset($_FILES[$name])) return 'error_unknown';

			if (!is_uploaded_file($_FILES[$name]['tmp_name'])) return 'error_unknown';

			# Check for upload errors

			if ($_FILES[$name]['error'] !== UPLOAD_ERR_OK) return self::translateError($_FILES[$name]['error']);

			# Check size

			if ($_FILES[$name]['size'] > (1024 * 1024 * 1024 * 2)) return 'error_size';

			# Check file extension

			$extensions = ['php', 'phtml', 'php3', 'php4', 'php5', 'phps'];

			if (in_array(Explorer::extension($_FILES[$name]['name'], false), $extensions)) return 'error_type';

			# Check target directory

			if (!Explorer::isDir($dir_name)) return 'error_dir';

			# Save uploaded file

			$file_name = ($dir_name . basename($_FILES[$name]['name']));

			if (!@move_uploaded_file($_FILES[$name]['tmp_name'], $file_name)) return 'error_save';

			# ------------------------

			return true;
		}
	}
}
