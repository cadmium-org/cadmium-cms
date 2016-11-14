<?php

namespace Modules\Informer\Handler {

	use Frames, Modules\Informer, Utils\View;

	class Information extends Frames\Admin\Area\Authorized {

		protected $title = 'TITLE_SYSTEM_INFORMATION';

		# Get contents

		private function getContents() {

			$contents = View::get('Blocks/Informer/Information');

			# Set server entries

			$contents->php_version          = phpversion();

			$contents->mysql_version        = Informer::mysqlVersion();

			# Set system entries

			$contents->system_version       = CADMIUM_VERSION;

			$contents->jquery_version       = JQUERY_VERSION;

			$contents->semantic_ui_version  = SEMANTIC_UI_VERSION;

			$contents->ckeditor_version     = CKEDITOR_VERSION;

			# ------------------------

			return $contents;
		}

		# Handle request

		protected function handle() {

			return $this->getContents();
		}
	}
}
