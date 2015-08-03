<?php

namespace System\Frames\Admin\Listview {

	use Error, Warning, System, System\Utils\Ajax, System\Utils\Auth, System\Utils\Config, System\Utils\Entity;
	use System\Utils\Extend, System\Utils\Lister, System\Utils\Messages, System\Utils\Pagination;
	use System\Utils\Requirements, System\Utils\Utils;

	use Agent, Arr, Cookie, Date, DB, Explorer, Form, Geo\Country, Geo\Timezone;
	use Headers, Language, Mailer, Number, Request, Session, String, Tag, Template, Url, Validate;

	abstract class Pages extends System\Frames\Admin\Handler {

		private $index = 0, $page = null, $form = null, $children = null;

		# Get children pages

		private function getChildren($disable_id = 0) {

			$children = array('items' => array(), 'total' => 0);

			$parent_id = ($this->page->id ? $this->page->id : 0);

			# Select pages

			$limit = (($this->index > 0) ? ((($this->index - 1) * CONFIG_ADMIN_PAGES_DISPLAY) . ", " . CONFIG_ADMIN_PAGES_DISPLAY) : '');

			$query = ("SELECT SQL_CALC_FOUND_ROWS pag.id, pag.visibility, pag.access, pag.name, pag.title, COUNT(chd.id) as children ") .

					 ("FROM " . TABLE_PAGES . " pag LEFT JOIN " . TABLE_PAGES . " chd ON chd.parent_id = pag.id ") .

					 ("WHERE pag.parent_id = " . $parent_id . " " . ($disable_id ? ("AND pag.id != " . $disable_id . " ") : "")) .

					 ("GROUP BY pag.id ORDER BY pag.title ASC, pag.id ASC" . ($limit ? (" LIMIT " . $limit) : ''));

			if (!(DB::send($query) && DB::last()->status)) return $children;

			# Process selection

			while (null !== ($page = DB::last()->row())) $children['items'][] = array (

				'id'            => intabs($page['id']),

				'visibility'    => boolval($page['visibility']),

				'access'        => intabs($page['access']),

				'name'          => strval($page['name']),

				'title'         => strval($page['title']),

				'children'      => intabs($page['children'])
			);

			# Count pages total

			if (DB::send('SELECT FOUND_ROWS() as total') && (DB::last()->rows === 1)) {

				$children['total'] = intabs(DB::last()->row()['total']);
			}

			# ------------------------

			return $children;
		}

		# Get path

		private function getPath() {

			if (!($path = $this->page->path)) return array();

			$count = count($path);

			foreach (array_keys($path) as $key) {

				$path[$key]['class'] = (($key === ($count - 1)) ? 'active section' : 'section');
			}

			return $path;
		}

		# Get contents

		private function getContents($ajax = false) {

			$contents = Template::block($ajax ? 'Contents/Content/Pages/Ajax/Main' : 'Contents/Content/Pages/List/Main');

			# Set general

			$contents->id = $this->page->id;

			$contents->title = ($this->page->title ? $this->page->title : ('- ' . Language::get('NONE')));

			# Set path

			$contents->path = $this->getPath();

			# Set actions

			if (0 === $this->page->id) $contents->block('actions')->disable(); else {

				$contents->block('actions')->link = $this->page->link;

				$contents->block('actions')->id = $this->page->id;
			}

			# Set form

			if (!$ajax) {

				if (0 === $this->page->id) $contents->block('parent')->disable();

				else $contents->block('parent')->title = $this->page->title;

				foreach ($this->form->fields() as $name => $block) $contents->block(('field_' . $name), $block);
			}

			# Set list

			$list = Template::group();

			foreach ($this->children['items'] as $page) {

				$list->add($item = Template::block($ajax ? 'Contents/Content/Pages/Ajax/Item' : 'Contents/Content/Pages/List/Item'));

				$item->id = $page['id']; $item->title = $page['title'];

				$item->icon = ((0 === $page['children']) ? 'file text outline' : 'folder');

				$item->access = Lister::access($page['access']);

				$item->block('browse')->class = ($page['visibility'] ? 'primary' : 'disabled');

				$item->block('browse')->link = ($this->page->link . '/' . $page['name']);

				if (!$ajax) $item->block('remove')->class = (($page['id'] !== 1) && ($page['children'] === 0) ? 'negative' : 'disabled');
			}

			if ($list->count() > 0) $contents->list = $list;

			# Set pagination

			if (!$ajax) {

				$display = CONFIG_ADMIN_PAGES_DISPLAY; $url = new Url('/admin/content/pages?parent_id=' . $this->page->id);

				$contents->pagination = Pagination::block($this->index, $display, $this->children['total'], $url);
			}

			# ------------------------

			return $contents;
		}

		# Handle list

		protected function handleList($error = false) {

			if (boolval($error)) Messages::error(Language::get('PAGES_ITEM_NOT_FOUND'));

			$this->index = Number::format(Request::get('index'), 1, 999999);

			# Create parent page

			$this->page = new Entity\Type\Page\Manager(Request::get('parent_id'));

			# Create form

			$this->form = new Form('page'); $fieldset = $this->form->fieldset();

			# Add form fields

			$fieldset->text     ('title', '', CONFIG_PAGE_TITLE_MAX_LENGTH, '', FORM_FIELD_REQUIRED);

			$fieldset->text     ('name', '', CONFIG_PAGE_NAME_MAX_LENGTH, '', FORM_FIELD_REQUIRED | FORM_FIELD_TRANSLIT);

			# Post form

			if (false !== ($post = $this->form->post()) && !$this->form->errors()) {

				if (true !== ($result = $this->page->create($post))) Messages::error(Language::get($result));

				else Request::redirect('/admin/content/pages?id=' . $this->page->created_id . '&submitted=create');
			}

			# Get children pages

			$this->children = $this->getChildren();

			# Fill template

			$this->setTitle(Language::get('TITLE_CONTENT_PAGES'));

			$this->setContents($this->getContents());

			# ------------------------

			return true;
		}

		# Handle ajax list

		protected function handleListAjax($active_id) {

			$active_id = intabs($active_id);

			# Create parent page

			$this->page = Entity\Factory::page(Request::get('parent_id'));

			# Get children pages

			$this->children = $this->getChildren($active_id);

			# Set contents

			Ajax::set('contents', $this->getContents(true)->contents(true));

			# ------------------------

			return true;
		}
	}
}
