<?php

namespace System\Forms\Admin\Install {

	use System\Extend, Form;

	class Check extends Form {

        # Get languages list

		private function getLanguages() {

			$languages = array();

			foreach (Extend\Languages::items() as $code => $language) $languages[$code] = $language['title'];

			# ------------------------

			return $languages;
		}

		# Get templates list

		private function getTemplates() {

			$templates = array();

			foreach (Extend\Templates::items() as $name => $template) $templates[$name] = $template['title'];

			# ------------------------

			return $templates;
		}

        # Constructor

        public function __construct() {

            parent::__construct();

            # Add fields

            $this->select('language', Extend\Languages::active(), $this->getLanguages(), '', FORM_FIELD_AUTO);

			$this->select('template', Extend\Templates::active(), $this->getTemplates(), '', FORM_FIELD_AUTO);
        }
    }
}
