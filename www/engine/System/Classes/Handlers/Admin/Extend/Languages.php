<?php

namespace System\Handlers\Admin\Extend {

	use Error, System, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config, System\Utils\Entity;
	use System\Utils\Extend, System\Utils\Lister, System\Utils\Messages, System\Utils\Pagination;
	use System\Utils\Requirements, System\Utils\Utils;

	use Agent, Arr, Cookie, Date, DB, Explorer, Form, Geo\Country, Geo\Timezone;
	use Headers, Language, Mailer, Number, Request, Session, String, Tag, Template, Url, Validate;

	class Languages extends System\Frames\Admin\Handler {

		private $section = null, $items = array();

		# Get items

		private function getItems($code, $default) {

			$code = strval($code); $default = strval($default);

			$items = Arr::subvalSort(System\Utils\Extend\Languages::items($this->section), 'title');

			if (System\Utils\Extend\Languages::valid($code) && isset($items[$code])) $active = $code;

			else if (System\Utils\Extend\Languages::valid($default) && isset($items[$default])) $active = $default;

			foreach (array_keys($items) as $code) $items[$code]['active'] = ($code === (isset($active) ? $active : key($items)));

			# ------------------------

			return $items;
		}

		# Save configuration

		private function setData($data) {

			$param = (($this->section === SECTION_ADMIN) ? CONFIG_PARAM_ADMIN_LANGUAGE : CONFIG_PARAM_SITE_LANGUAGE);

			if (false === Config::set($param, $data['code'])) return Ajax::error(Language::get('LANGUAGES_ERROR_CODE'));

			if (false === Config::save()) return Ajax::error(Language::get('LANGUAGES_ERROR_SAVE'));

			# ------------------------

			return true;
		}

		# Get sections loop

		private function getSectionsLoop() {

			$loop = array(); $sections = array();

			$sections[SECTION_SITE]     = Language::get('SECTION_SITE');
			$sections[SECTION_ADMIN]    = Language::get('SECTION_ADMIN');

			foreach ($sections as $name => $title) {

				$class = (($name === $this->section) ? 'active item' : 'item');

				$loop[] = array('name' => strtolower($name), 'title' => $title, 'class' => $class);
			}

			return $loop;
		}

		# Get contents

		private function getContents() {

			$contents = Template::block('Contents/Extend/Languages/Main');

			# Set sections

			$contents->sections = $this->getSectionsLoop();

			$contents->section = $this->section;

			# Set list

			$list = Template::group();

			foreach ($this->items as $code => $language) {

				$list->add($item = Template::block('Contents/Extend/Languages/Item'));

				$item->code = $code; $item->country = $language['country']; $item->title = $language['title'];

				$item->is_active = boolval($language['active']);
			}

			if ($list->count()) $contents->block('list', $list);

			# ------------------------

			return $contents;
		}

		# Handle request

		protected function handle() {

			list ($this->section, $code, $default) = (strcasecmp(Request::get('list'), SECTION_ADMIN) === 0) ?

				array(SECTION_ADMIN, CONFIG_ADMIN_LANGUAGE, CONFIG_ADMIN_LANGUAGE_DEFAULT) :

				array(SECTION_SITE, CONFIG_SITE_LANGUAGE, CONFIG_SITE_LANGUAGE_DEFAULT);

			$this->items = $this->getItems($code, $default);

			# Fill template

			$this->setTitle(Language::get('TITLE_EXTEND_LANGUAGES'));

			$this->setContents($this->getContents());

			# ------------------------

			return true;
		}

		# Handle ajax request

		protected function handleAjax() {

			list ($this->section, $code, $default) = (strcasecmp(Request::get('list'), SECTION_ADMIN) === 0) ?

				array(SECTION_ADMIN, CONFIG_ADMIN_LANGUAGE, CONFIG_ADMIN_LANGUAGE_DEFAULT) :

				array(SECTION_SITE, CONFIG_SITE_LANGUAGE, CONFIG_SITE_LANGUAGE_DEFAULT);

			$this->items = $this->getItems($code, $default);

			# Process form

			$form = new Form('ajax'); $form->fieldset()->hidden('code');

			return ((false !== ($post = $form->post())) ? $this->setData($post) : false);
		}
	}
}
