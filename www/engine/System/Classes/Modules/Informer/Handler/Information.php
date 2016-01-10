<?php

namespace Modules\Informer\Handler {

	use Modules\Informer, Utils\View;

	class Information {

		# Get contents

		private function getContents() {

			$contents = View::get('Blocks\Informer\Information');

			# Set core entries

			$contents->system_version       = CADMIUM_VERSION;

			$contents->php_version          = phpversion();

			$contents->mysql_version        = Informer::mysqlVersion();

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
