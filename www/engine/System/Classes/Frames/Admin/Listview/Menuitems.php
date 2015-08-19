<?php

namespace System\Frames\Admin\Listview {

	use Error, System, System\Forms, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config;
	use System\Utils\Entitizer, System\Utils\Extend, System\Utils\Lister, System\Utils\Messages;
	use System\Utils\Pagination, System\Utils\Requirements, System\Utils\Utils, System\Utils\View;

	use Agent, Arr, Cookie, Date, DB, Explorer, Form, Geo\Country, Geo\Timezone;
	use Headers, Language, Mailer, Number, Request, Session, String, Tag, Template, Url, Validate;

	abstract class Menuitems extends System\Frames\Admin\Component\Content {

		private $index = 0, $parent = null, $form_create = null, $children = null;

		# Get children menuitems

		private function getChildren($disable_id = 0) {

			$children = array('items' => array(), 'total' => 0);

			# Select menuitems

			$limit = (($this->index > 0) ? ((($this->index - 1) * CONFIG_ADMIN_MENUITEMS_DISPLAY) . ", " . CONFIG_ADMIN_MENUITEMS_DISPLAY) : '');

			$query = ("SELECT SQL_CALC_FOUND_ROWS men.id, men.position, men.link, men.text, COUNT(chd.id) as children ") .

					 ("FROM " . TABLE_MENU . " men LEFT JOIN " . TABLE_MENU . " chd ON chd.parent_id = men.id ") .

					 ("WHERE men.parent_id = " . $this->parent->id . " " . ($disable_id ? ("AND men.id != " . $disable_id . " ") : "")) .

					 ("GROUP BY men.id ORDER BY men.position ASC, men.id ASC" . ($limit ? (" LIMIT " . $limit) : ''));

			if (!(DB::send($query) && DB::last()->status)) return $children;

			# Process selection

			while (null !== ($menuitem = DB::last()->row())) $children['items'][] = array (

				'id'            => intabs($menuitem['id']),

				'position'      => intabs($menuitem['position']),

				'link'          => strval($menuitem['link']),

				'text'          => strval($menuitem['text']),

				'children'      => intabs($menuitem['children'])
			);

			# Count menuitems total

			if (DB::send('SELECT FOUND_ROWS() as total') && (DB::last()->rows === 1)) {

				$children['total'] = intabs(DB::last()->row()['total']);
			}

			# ------------------------

			return $children;
		}

		# Get path

		private function getListPath() {

			if (!($path = $this->parent->path)) return array();

			$count = count($path);

			foreach (array_keys($path) as $key) {

				$path[$key]['class'] = (($key === ($count - 1)) ? 'active section' : 'section');
			}

			return $path;
		}

		# Get children

		private function getChildrenBlock($ajax = false) {

			$children = Template::group();

			foreach ($this->children['items'] as $menuitem) {

				$children->add($item = View::get($ajax ? 'Blocks/Contents/Content/Menuitems/Ajax/Item' : 'Blocks/Contents/Content/Menuitems/Listview/Item'));

				$item->id = $menuitem['id']; $item->text = $menuitem['text'];

				$item->icon = ((0 === $menuitem['children']) ? 'file text outline' : 'folder');

				$item->position = $menuitem['position'];

				$item->block('browse')->class = ($menuitem['link'] ? 'primary' : 'disabled');

				$item->block('browse')->link = $menuitem['link'];

				if (!$ajax) $item->block('remove')->class = (($menuitem['children'] === 0) ? 'negative' : 'disabled');
			}

			return $children;
		}

		# Get pagination

		private function getPaginationBlock() {

			$display = CONFIG_ADMIN_MENUITEMS_DISPLAY;

			$url = new Url('/admin/content/menuitems?parent_id=' . $this->parent->id);

			return Pagination::block($this->index, $display, $this->children['total'], $url);
		}

		# Get contents

		private function getListContents($ajax = false) {

			$contents = View::get($ajax ? 'Blocks/Contents/Content/Menuitems/Ajax/Main' : 'Blocks/Contents/Content/Menuitems/Listview/Main');

			# Set general

			$contents->id = $this->parent->id;

			$contents->text = ($this->parent->text ? $this->parent->text : ('- ' . Language::get('NONE')));

			# Set path

			$contents->path = $this->getListPath();

			# Set actions

			if (0 === $this->parent->id) $contents->block('actions')->disable(); else {

				$contents->block('actions')->link = $this->parent->link;

				$contents->block('actions')->id = $this->parent->id;
			}

			# Set form

			if (!$ajax) {

				if (0 === $this->parent->id) $contents->block('parent')->disable();

				else $contents->block('parent')->text = $this->parent->text;

				$this->form_create->implement($contents);
			}

			# Set children

			$children = $this->getChildrenBlock($ajax);

			if ($children->count() > 0) $contents->children = $children;

			# Set pagination

			if (!$ajax) $contents->pagination = $this->getPaginationBlock();

			# ------------------------

			return $contents;
		}

		# Handle list

		protected function handleList($error = false) {

			if (boolval($error)) Messages::error(Language::get('MENUITEMS_ITEM_NOT_FOUND'));

			$this->index = Number::format(Request::get('index'), 1, 999999);

			# Create parent menuitem

			$this->parent = Entitizer::manager(ENTITY_TYPE_MENUITEM, Request::get('parent_id'));

			# Create form

			$this->form_create = new Forms\Admin\Content\Menuitems\Create();

			# Post form

			if (false !== ($post = $this->form_create->post()) && !$this->form_create->errors()) {

				if (false === ($result = $this->parent->createChild($post))) Messages::error(Language::get($result));

				else Request::redirect('/admin/content/menuitems?id=' . $result->id . '&submitted=create');
			}

			# Get children menuitems

			$this->children = $this->getChildren();

			# Fill template

			$this->setTitle(Language::get('TITLE_CONTENT_MENUITEMS'));

			$this->setContents($this->getListContents());

			# ------------------------

			return true;
		}

		# Handle ajax list

		protected function handleListAjax($active_id) {

			$active_id = intabs($active_id);

			# Create parent menuitem

			$this->parent = Entitizer::menuitem(Request::get('parent_id'));

			# Get children menuitems

			$this->children = $this->getChildren($active_id);

			# Set contents

			Ajax::set('contents', $this->getListContents(true)->contents(true));

			# ------------------------

			return true;
		}
	}
}
