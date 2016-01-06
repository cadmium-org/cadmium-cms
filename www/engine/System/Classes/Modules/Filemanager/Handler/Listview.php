<?php

namespace Modules\Filemanager\Handler {

	use Modules\Filemanager, Utils\Messages, Utils\Pagination, Utils\Uploader, Utils\View;
	use Ajax, Arr, Explorer, Language, Number, Request, Template, Url;

	class Listview {

		private $parent = null, $form = null, $index = 0, $items = [];

		# Get items

		private function getItems() {

			$dirs = []; $files = [];

			$prefix = (('' !== $this->parent->path()) ? ($this->parent->path() . '/') : '');

			# Read parent directory contents

			if (false !== ($handler = @opendir($this->parent->pathFull()))) {

				while (false !== ($name = readdir($handler))) {

					if (in_array($name, ['.', '..', '.empty'], true)) continue;

					$path = ($prefix . $name); $path_full = ($this->parent->pathFull() . $name);

					$data = ['name' => $name, 'path' => $path, 'path_full' => $path_full];

					if (@is_dir($path_full)) $dirs[] = array_merge($data, ['type' => FILEMANAGER_TYPE_DIR]);

					else if (@is_file($path_full)) $files[] = array_merge($data, ['type' => FILEMANAGER_TYPE_FILE]);
				}

				closedir($handler);
			}

			# Sort arrays

			Arr::sortby($dirs, 'name'); Arr::sortby($files, 'name');

			# Extract a set of items to display

			$list = array_merge($dirs, $files); $total = count($list); $display = CONFIG_ADMIN_FILEMANAGER_ITEMS_DISPLAY;

			$list = array_splice($list, (($this->index - 1) * $display), $display);

			# ------------------------

			return ['list' => $list, 'total' => $total];
		}

		# Get directory item block

		private function getDirItemBlock(array $data) {

			$view = View::get('Blocks\Filemanager\Listview\Item\Dir');

			# Set data

			$view->name = $data['name']; $view->path = $data['path'];

			$view->parent = $this->parent->path();

			# ------------------------

			return $view;
		}

		# Get file item block

		private function getFileItemBlock(array $data) {

			$view = View::get('Blocks\Filemanager\Listview\Item\File');

			# Set data

			$view->name = $data['name']; $view->path = $data['path'];

			$view->type = Filemanager\Utils\Mime::type($data['name']);

			$view->size = Number::size(@filesize($data['path_full']));

			$view->parent = $this->parent->path();

			# ------------------------

			return $view;
		}

		# Get items block

		private function getItemsBlock() {

			$items = Template::group();

			foreach ($this->items['list'] as $item) {

				if ($item['type'] === FILEMANAGER_TYPE_DIR) $items->add($this->getDirItemBlock($item));

				else if ($item['type'] === FILEMANAGER_TYPE_FILE) $items->add($this->getFileItemBlock($item));
			}

			# ------------------------

			return $items;
		}

		# Get pagination block

		private function getPaginationBlock() {

			$query = (('' !== $this->parent->path()) ? ('?parent=' . $this->parent->path()) : '');

			$url = new Url(INSTALL_PATH . '/admin/content/filemanager' . $query);

			# ------------------------

			return Pagination::block($this->index, CONFIG_ADMIN_FILEMANAGER_ITEMS_DISPLAY, $this->items['total'], $url);
		}

		# Get contents

		private function getContents() {

			$contents = View::get('Blocks\Filemanager\Listview\Main');

			# Set parent

			$contents->parent = $this->parent->path();

			# Set breadcrumbs

			$contents->breadcrumbs = $this->parent->breadcrumbs();

			# Set link

			$query = (('' !== $this->parent->path()) ? ('?parent=' . $this->parent->path()) : '');

			$contents->link = (INSTALL_PATH . '/admin/content/filemanager' . $query);

			# Implement form

			$this->form->implement($contents);

			# Set items

			$items = $this->getItemsBlock();

			if ($items->count() > 0) $contents->items = $items;

			# Set pagination

			$contents->pagination = $this->getPaginationBlock();

			# ------------------------

			return $contents;
		}

		# Handle request

		public function handle() {

			# Create parent

			$this->parent = Filemanager::open(Request::get('parent'));

			# Create form

			$this->form = new Filemanager\Form\Create();

			# Save uploaded file

			$upload = (Uploader::submit('upload', $this->parent->pathFull()));

			# Handle form

			if ($upload || $this->form->handle(new Filemanager\Controller\Create($this->parent))) {

				$query = (('' !== $this->parent->path()) ? ('?parent=' . $this->parent->path()) : '');

				Request::redirect(INSTALL_PATH . '/admin/content/filemanager' . $query);
			}

			# Get index

			$this->index = Number::format(Request::get('index'), 1, 999999);

			# Get items

			$this->items = $this->getItems();

			# ------------------------

			return $this->getContents();
		}
	}
}
