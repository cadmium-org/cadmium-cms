<?php

namespace Modules\Informer\Handler {

	use Frames, Modules\Informer, Utils\View, Language, Template;

	class Information extends Frames\Admin\Area\Authorized {

		protected $title = 'TITLE_SYSTEM_INFORMATION';

		# Process debug mode block

		private function processDebugMode(Template\Block $debug_mode) {

			if (DEBUG_MODE) {

				$debug_mode->class = 'red';

				$debug_mode->text = Language::get('INFORMATION_VALUE_DEBUG_MODE_ON');

			} else {

				$debug_mode->class = '';

				$debug_mode->text = Language::get('INFORMATION_VALUE_DEBUG_MODE_OFF');
			}
		}

		# Get contents

		private function getContents() {

			$contents = View::get('Blocks/Informer/Information');

			# Set server entries

			$contents->os_version           = Informer::osVersion();

			$contents->php_version          = phpversion();

			$contents->mysql_version        = Informer::mysqlVersion();

			# Set system entries

			$contents->system_version       = CADMIUM_VERSION;

			# Set external entries

			$contents->jquery_version       = JQUERY_VERSION;

			$contents->semantic_ui_version  = SEMANTIC_UI_VERSION;

			$contents->ckeditor_version     = CKEDITOR_VERSION;

			# Set debug mode

			$this->processDebugMode($contents->getBlock('debug_mode'));

			# ------------------------

			return $contents;
		}

		# Handle request

		protected function handle() {

			return $this->getContents();
		}
	}
}
