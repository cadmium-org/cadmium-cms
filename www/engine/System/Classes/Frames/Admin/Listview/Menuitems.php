<?php

namespace System\Frames\Admin\Listview {

	use Error, Warning, System, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config, System\Utils\Entity;
	use System\Utils\Extend, System\Utils\Lister, System\Utils\Messages, System\Utils\Pagination;
	use System\Utils\Requirements, System\Utils\Utils;

	use Agent, Arr, Cookie, Date, DB, Explorer, Form, Geo\Country, Geo\Timezone;
	use Headers, Language, Mailer, Number, Request, Session, String, Tag, Template, Url, Validate;

	abstract class Menuitems extends System\Frames\Admin\Handler {

		private $index = false, $menuitem = false, $form = false, $children = false;

		# Get children menuitems

		private function getChildren($disable_id = false) {

			$children = array('items' => array(), 'total' => 0);

			$parent_id = ($this->menuitem->id ? $this->menuitem->id : 0);

			# Select menuitems

			$limit = ($this->index ? ((($this->index - 1) * CONFIG_ADMIN_MENUITEMS_DISPLAY) . ", " . CONFIG_ADMIN_MENUITEMS_DISPLAY) : false);

			$query = ("SELECT SQL_CALC_FOUND_ROWS men.id, men.position, men.link, men.text, COUNT(chd.id) as children ") .

					 ("FROM " . TABLE_MENU . " men LEFT JOIN " . TABLE_MENU . " chd ON chd.parent_id = men.id ") .

					 ("WHERE men.parent_id = " . $parent_id . " " . ($disable_id ? ("AND men.id != " . $disable_id . " ") : "")) .

					 ("GROUP BY men.id ORDER BY men.position ASC, men.id ASC" . ($limit ? (" LIMIT " . $limit) : ''));

			if (!(DB::send($query) && DB::last()->status)) return $children;

			# Process selection

			while (null !== ($menuitem = DB::last()->row())) $children['items'][] = array (

				'id'            => Number::unsigned($menuitem['id']),

				'position'      => Number::unsigned($menuitem['position']),

				'link'          => String::validate($menuitem['link']),

				'text'          => String::validate($menuitem['text']),

				'children'      => Number::unsigned($menuitem['children'])
			);

			# Count menuitems total

			if (DB::send('SELECT FOUND_ROWS() as total') && (DB::last()->rows === 1)) {

				$children['total'] = Number::unsigned(DB::last()->row()['total']);
			}

			# ------------------------

			return $children;
		}

		# Get path

		private function getPath() {

			if (false === ($path = $this->menuitem->path)) return array();

			$count = count($path);

			foreach (array_keys($path) as $key) {

				$path[$key]['class'] = (($key === ($count - 1)) ? 'active section' : 'section');
			}

			return $path;
		}

		# Get contents

		private function getContents($ajax = false) {

			$contents = Template::block($ajax ? 'Contents/Content/Menuitems/Ajax/Main' : 'Contents/Content/Menuitems/List/Main');

			# Set general

			$contents->id = ((false !== $this->menuitem->id) ? $this->menuitem->id : 0);

			$contents->text = ((false !== $this->menuitem->text) ? $this->menuitem->text : ('- ' . Language::get('NONE')));

			# Set path

			$contents->path = $this->getPath();

			# Set actions

			if (false === $this->menuitem->id) $contents->block('actions')->disable(); else {

				$contents->block('actions')->link = $this->menuitem->link;

				$contents->block('actions')->id = $this->menuitem->id;
			}

			# Set form

			if (!$ajax) {

				if (false === $this->menuitem->id) $contents->block('parent')->disable();

				else $contents->block('parent')->text = $this->menuitem->text;

				foreach ($this->form->fields() as $name => $block) $contents->block(('field_' . $name), $block);
			}

			# Set list

			$list = Template::group();

			foreach ($this->children['items'] as $menuitem) {

				$list->add($item = Template::block($ajax ? 'Contents/Content/Menuitems/Ajax/Item' : 'Contents/Content/Menuitems/List/Item'));

				$item->id = $menuitem['id']; $item->text = $menuitem['text'];

				$item->icon = ((0 === $menuitem['children']) ? 'file text outline' : 'folder');

				$item->position = $menuitem['position'];

				$item->block('browse')->class = ((false !== $menuitem['link']) ? 'primary' : 'disabled');

				$item->block('browse')->link = $menuitem['link'];

				if (!$ajax) $item->block('remove')->class = (($menuitem['children'] === 0) ? 'negative' : 'disabled');
			}

			if ($list->count() > 0) $contents->list = $list;

			# Set pagination

			if (!$ajax) {

				$display = CONFIG_ADMIN_MENUITEMS_DISPLAY; $url = new Url('/admin/content/menuitems?parent_id=' . $this->menuitem->id);

				$contents->pagination = Pagination::block($this->index, $display, $this->children['total'], $url);
			}

			# ------------------------

			return $contents;
		}

		# Handle list

		protected function handleList($error = false) {

			if (Validate::boolean($error)) Messages::error(Language::get('MENUITEMS_ITEM_NOT_FOUND'));

			$this->index = Number::index(Request::get('index'));

			# Create parent menuitem

			$this->menuitem = new Entity\Type\Menuitem\Manager(Request::get('parent_id'));

			# Create form

			$this->form = new Form('menuitem'); $fieldset = $this->form->fieldset();

			# Add form fields

			$fieldset->text     ('text', false, CONFIG_MENUITEM_TEXT_MAX_LENGTH, false, FORM_FIELD_REQUIRED);

			$fieldset->text     ('link', false, CONFIG_MENUITEM_LINK_MAX_LENGTH);

			# Post form

			if (false !== ($post = $this->form->post()) && !$this->form->errors()) {

				if (true !== ($result = $this->menuitem->create($post))) Messages::error(Language::get($result));

				else Request::redirect('/admin/content/menuitems?id=' . $this->menuitem->created_id . '&submitted=create');
			}

			# Get children menuitems

			$this->children = $this->getChildren();

			# Fill template

			$this->setTitle(Language::get('TITLE_CONTENT_MENUITEMS'));

			$this->setContents($this->getContents());

			# ------------------------

			return true;
		}

		# Handle ajax list

		protected function handleListAjax($active_id) {

			$active_id = Number::unsigned($active_id);

			# Create parent menuitem

			$this->menuitem = Entity\Factory::menuitem(Request::get('parent_id'));

			# Get children menuitems

			$this->children = $this->getChildren($active_id);

			# Set contents

			Ajax::set('contents', $this->getContents(true)->contents(true));

			# ------------------------

			return true;
		}
	}
}

?>
