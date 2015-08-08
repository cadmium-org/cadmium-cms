<?php

namespace System\Handlers\Admin\Extend {

	use Error, System, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config, System\Utils\Entity;
	use System\Utils\Extend, System\Utils\Lister, System\Utils\Messages, System\Utils\Pagination;
	use System\Utils\Requirements, System\Utils\Utils;

	use Agent, Arr, Cookie, Date, DB, Explorer, Form, Geo\Country, Geo\Timezone;
	use Headers, Language, Mailer, Number, Request, Session, String, Tag, Template, Url, Validate;

	class Templates extends System\Frames\Admin\Handler {

		private $section = null, $items = array();

		# Get items

		private function getItems($name, $default) {

			$name = strval($name); $default = strval($default);

			$items = Arr::subvalSort(System\Utils\Extend\Templates::items($this->section), 'title');

			if (System\Utils\Extend\Templates::valid($name) && isset($items[$name])) $active = $name;

			else if (System\Utils\Extend\Templates::valid($default) && isset($items[$default])) $active = $default;

			foreach (array_keys($items) as $name) $items[$name]['active'] = ($name === (isset($active) ? $active : key($items)));

			# ------------------------

			return $items;
		}

		# Save configuration

		private function setData($data) {

			$param = (($this->section === SECTION_ADMIN) ? CONFIG_PARAM_ADMIN_TEMPLATE : CONFIG_PARAM_SITE_TEMPLATE);

			if (false === Config::set($param, $data['name'])) return Ajax::error(Language::get('TEMPLATES_ERROR_CODE'));

			if (false === Config::save()) return Ajax::error(Language::get('TEMPLATES_ERROR_SAVE'));

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

			$contents = Template::block('Contents/Extend/Templates/Main');

			# Set sections

			$contents->sections = $this->getSectionsLoop();

			$contents->section = $this->section;

			# Set list

			$list = Template::group();

			foreach ($this->items as $name => $template) {

				$list->add($item = Template::block('Contents/Extend/Templates/Item'));

				$item->name = $name; $item->title = $template['title'];

				$item->is_active = boolval($template['active']);
			}

			if ($list->count()) $contents->block('list', $list);

			# ------------------------

			return $contents;
		}

		# Handle request

		protected function handle() {

			list ($this->section, $name, $default) = (strcasecmp(Request::get('list'), SECTION_ADMIN) === 0) ?

				array(SECTION_ADMIN, CONFIG_ADMIN_TEMPLATE, CONFIG_ADMIN_TEMPLATE_DEFAULT) :

				array(SECTION_SITE, CONFIG_SITE_TEMPLATE, CONFIG_SITE_TEMPLATE_DEFAULT);

			$this->items = $this->getItems($name, $default);

			# Fill template

			$this->setTitle(Language::get('TITLE_EXTEND_TEMPLATES'));

			$this->setContents($this->getContents());

			# ------------------------

			return true;
		}

		# Handle ajax request

		protected function handleAjax() {

			list ($this->section, $name, $default) = (strcasecmp(Request::get('list'), SECTION_ADMIN) === 0) ?

				array(SECTION_ADMIN, CONFIG_ADMIN_TEMPLATE, CONFIG_ADMIN_TEMPLATE_DEFAULT) :

				array(SECTION_SITE, CONFIG_SITE_TEMPLATE, CONFIG_SITE_TEMPLATE_DEFAULT);

			$this->items = $this->getItems($name, $default);

			# Process form

			$form = new Form('ajax'); $form->virtual('name');

			return ((false !== ($post = $form->post())) ? $this->setData($post) : false);
		}
	}
}
