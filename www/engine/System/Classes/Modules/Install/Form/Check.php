<?php

namespace System\Modules\Install\Form {

	use System\Modules\Extend, System\Utils\Form;

	class Check extends Form {

		# Get languages list

		private function getLanguages() {

			$languages = [];

			foreach (Extend\Languages::items() as $code => $language) $languages[$code] = $language['title'];

			# ------------------------

			return $languages;
		}

		# Get templates list

		private function getTemplates() {

			$templates = [];

			foreach (Extend\Templates::items() as $name => $template) $templates[$name] = $template['title'];

			# ------------------------

			return $templates;
		}

		# Constructor

		public function __construct() {

			# Add fields

			$this->select('language', Extend\Languages::active(), $this->getLanguages(), null, ['auto' => true]);

			$this->select('template', Extend\Templates::active(), $this->getTemplates(), null, ['auto' => true]);
		}
	}
}
