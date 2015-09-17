<?php

namespace System\Modules\Info\Handler {

	use System\Modules\Info, System\Utils\View;

	class Information {

		# Get contents

		private function getContents() {

			$contents = View::get('Blocks\Info\Information');

			# Set core entries

			$contents->system_version       = CADMIUM_VERSION;

			$contents->php_version          = phpversion();

			$contents->mysql_version        = Info::mysqlVersion();

			# Set external entries

			$contents->jquery_version       = JQUERY_VERSION;

			$contents->semantic_ui_version  = SEMANTIC_UI_VERSION;

			$contents->ckeditor_version     = CKEDITOR_VERSION;

			# ------------------------

			return $contents;
		}

		# Handle request

		public function handle() {

			return $this->getContents();
		}
	}
}
