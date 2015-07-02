<?php

namespace System\Handlers\Admin\System {
	
	use System, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config, System\Utils\Entity;
	use System\Utils\Lister, System\Utils\Messages, System\Utils\Pagination, System\Utils\Utils;
	use Agent, Arr, Cookie, Date, DB, Explorer, Form, Geo\Country, Geo\Timezone;
	use Headers, Language, Mailer, Number, Request, Session, String, Tag, Template, Url, Validate;
	
	class Info extends System\Frames\Admin\Handler {
		
		# Get contents
		
		private function getContents() {
			
			$contents = Template::block('Contents/System/Info');
			
			$contents->system_version = CADMIUM_VERSION;
			
			$contents->php_version = phpversion();
			
			# ------------------------
			
			return $contents;
		}
		
		# Handle request
		
		protected function handle() {
			
			# Fill template
			
			$this->setTitle(Language::get('TITLE_SYSTEM_INFO'));
			
			$this->setContents($this->getContents());
			
			# ------------------------
			
			return true;
		}
	}
}

?>