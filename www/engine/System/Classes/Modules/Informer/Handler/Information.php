<?php

/**
 * @package Cadmium\System\Modules\Informer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Informer\Handler {

	use Frames, Modules\Install, Utils\Validate, Utils\View, DB, Language, Template;

	class Information extends Frames\Admin\Area\Panel {

		protected $title = 'TITLE_SYSTEM_INFORMATION';

		/**
		 * Set common entries
		 */

		private function setCommonEntries(Template\Block $contents) {

			# Set server entries

			$contents->os_version           = (php_uname('s') . ', ' . php_uname('v'));

			$contents->php_version          = phpversion();

			$contents->mysql_version        = DB::getVersion();

			# Set system entries

			$contents->system_version       = CADMIUM_VERSION;

			$contents->debug_mode_class     = (DEBUG_MODE ? 'red' : 'grey');

			$contents->debug_mode_value     = Language::get('INFORMATION_VALUE_DEBUG_MODE_' . (DEBUG_MODE ? 'ON' : 'OFF'));

			# Set third-party entries

			$contents->jquery_version       = JQUERY_VERSION;

			$contents->semantic_ui_version  = SEMANTIC_UI_VERSION;

			$contents->ckeditor_version     = CKEDITOR_VERSION;
		}

		/**
		 * Set PHP entries
		 */

		private function setPhpEntries(Template\Block $contents) {

			$status_value = function (string $value) { return (Validate::boolean($value) ? 'On' : 'Off'); };

			# Set errors entries

			$contents->display_errors_class             = (ini_get('display_errors') ? 'orange' : 'green');

			$contents->display_errors_value             = $status_value(ini_get('display_errors'));

			$contents->display_startup_errors_class     = (ini_get('display_startup_errors') ? 'orange' : 'green');

			$contents->display_startup_errors_value     = $status_value(ini_get('display_startup_errors'));

			# Set file uploads entries

			$contents->file_uploads_class               = (ini_get('file_uploads') ? 'green' : 'red');

			$contents->file_uploads_value               = $status_value(ini_get('file_uploads'));

			$contents->upload_max_filesize              = ini_get('upload_max_filesize');

			$contents->post_max_size                    = ini_get('post_max_size');
		}

		/**
		 * Set diagnostics entries
		 */

		private function setDiagnosticsEntries(Template\Block $contents) {

			$extension_value = function (bool $value) {

				return Language::get('INFORMATION_VALUE_EXTENSION_' . (!$value ? 'NOT_' : '') . 'LOADED' );
			};

			$dir_value = function (bool $value) {

				return Language::get('INFORMATION_VALUE_DIR_' . (!$value ? 'NOT_' : '') . 'WRITABLE' );
			};

			# Get loops

			$extensions = $contents->getLoop('extensions'); $dirs = $contents->getLoop('dirs');

			# Set extensions

			foreach (Install::getExtensions() as $name => $status) {

				$name = Language::get('INFORMATION_ROW_EXTENSION_' . strtoupper($name));

				$class = ($status ? 'green' : 'red'); $value = $extension_value($status);

				$extensions->addItem(['name' => $name, 'class' => $class, 'value' => $value]);
			}

			# Set directories

			foreach (Install::getDirs() as $name => $status) {

				$name = Language::get('INFORMATION_ROW_DIR_' . strtoupper($name));

				$class = ($status ? 'green' : 'red'); $value = $dir_value($status);

				$dirs->addItem(['name' => $name, 'class' => $class, 'value' => $value]);
			}
		}

		/**
		 * Get the contents block
		 */

		private function getContents() : Template\Block {

			$contents = View::get('Blocks/Informer/Information');

			# Set entries

			$this->setCommonEntries($contents);

			$this->setPhpEntries($contents);

			$this->setDiagnosticsEntries($contents);

			# ------------------------

			return $contents;
		}

		/**
		 * Handle a request
		 */

		protected function handle() : Template\Block {

			return $this->getContents();
		}
	}
}
