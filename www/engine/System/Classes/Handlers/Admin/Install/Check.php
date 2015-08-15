<?php

namespace System\Handlers\Admin\Install {

	use Error, System, System\Forms, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config;
	use System\Utils\Entity, System\Utils\Extend, System\Utils\Lister, System\Utils\Messages;
	use System\Utils\Pagination, System\Utils\Requirements, System\Utils\Utils, System\Utils\View;

	use Agent, Arr, Cookie, Date, DB, Explorer, Form, Geo\Country, Geo\Timezone;
	use Headers, Language, Mailer, Number, Request, Session, String, Tag, Template, Url, Validate;

	class Check extends System\Frames\Admin\Component\Install {

		private $form = null;

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

		# Get requirements

		private function getRequirements() {

			$requirements = array();

			foreach (Requirements::get() as $name => $value) {

				$class = ($value ? 'positive' : 'negative'); $icon = ($value ? 'check circle' : 'warning circle');

				$text = Language::get('INSTALL_REQUIREMENT_' . strtoupper($name) . '_' . ($value ? 'SUCCESS' : 'FAIL'));

				$requirements[] = array('class' => $class, 'icon' => $icon, 'text' => $text);
			}

			return $requirements;
		}

		# Get contents

		private function getContents() {

			$contents = Template::block('Contents/Install/Check');

			# Set form

			$this->form->implement($contents);

			# Set requirements

			$contents->php_version = phpversion();

			$contents->requirements = $this->getRequirements();

			# Set button

			$contents->block('button')->value = intabs(Requirements::status());

			$contents->block('button')->text = Language::get(Requirements::status() ? 'CONTINUE' : 'RECHECK');

			# ------------------------

			return $contents;
		}

		# Handle request

		protected function handle() {

			# Create form

			$this->form = new Form();

			# Add form fields

            $this->form->select       ('language', Extend\Languages::active(), $this->getLanguages(), '', FORM_FIELD_AUTO);

			$this->form->select       ('template', Extend\Templates::active(), $this->getTemplates(), '', FORM_FIELD_AUTO);

			# Fill template

			$this->setTitle(Language::get('INSTALL_TITLE_CHECK'));

			$this->setContents($this->getContents());

			# ------------------------

			return true;
		}
	}
}
