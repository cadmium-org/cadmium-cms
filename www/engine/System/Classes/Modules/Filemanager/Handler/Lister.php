<?php

namespace Modules\Filemanager\Handler {

	use Frames, Modules\Filemanager, Modules\Settings, Utils\Messages, Utils\Pagination, Utils\Uploader, Utils\View;
	use Ajax, Arr, Explorer, Language, Number, Request, Template, Url;

	class Lister extends Frames\Admin\Area\Panel {

		protected $_title = 'TITLE_CONTENT_FILEMANAGER';

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

					if (@is_dir($path_full)) $dirs[] = ($data + ['type' => FILEMANAGER_TYPE_DIR]);

					else if (@is_file($path_full)) $files[] = ($data + ['type' => FILEMANAGER_TYPE_FILE]);
				}

				closedir($handler);
			}

			# Sort arrays

			Arr::sortby($dirs, 'name'); Arr::sortby($files, 'name');

			# Extract a set of items to display

			$list = ($dirs + $files); $total = count($list); $display = Settings::get('admin_display_files');

			$list = array_splice($list, (($this->index - 1) * $display), $display);

			# ------------------------

			return ['list' => $list, 'total' => $total];
		}

		# Get directory item block

		private function getDirItemBlock(array $data) {

			$view = View::get('Blocks/Filemanager/Lister/Item/Dir');

			# Set data

			$view->name = $data['name']; $view->path = $data['path'];

			$view->parent = $this->parent->path();

			# ------------------------

			return $view;
		}

		# Get file item block

		private function getFileItemBlock(array $data) {

			$view = View::get('Blocks/Filemanager/Lister/Item/File');

			# Set data

			$view->name = $data['name']; $view->path = $data['path'];

			$view->type = Filemanager\Utils\Mime::type($data['name']);

			$view->size = Number::size(@filesize($data['path_full']));

			$view->parent = $this->parent->path();

			# ------------------------

			return $view;
		}

		# Get pagination block

		private function getPaginationBlock() {

			$query = (('' !== $this->parent->path()) ? ('?parent=' . $this->parent->path()) : '');

			$url = new Url(INSTALL_PATH . '/admin/content/filemanager' . $query);

			# ------------------------

			return Pagination::block($this->index, Settings::get('admin_display_files'), $this->items['total'], $url);
		}

		# Get contents

		private function getContents() {

			$contents = View::get('Blocks/Filemanager/Lister/Main');

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

			$items = $contents->getBlock('items');

			foreach ($this->items['list'] as $item) {

				if ($item['type'] === FILEMANAGER_TYPE_DIR) $items->addItem($this->getDirItemBlock($item));

				else if ($item['type'] === FILEMANAGER_TYPE_FILE) $items->addItem($this->getFileItemBlock($item));
			}

			# Set pagination

			$contents->pagination = $this->getPaginationBlock();

			# ------------------------

			return $contents;
		}

		# Handle request

		protected function handle() {

			# Create parent

			$this->parent = Filemanager::open(Request::get('parent'));

			# Create form

			$this->form = new Filemanager\Form\Create();

			# Save uploaded file

			$upload = (Uploader::submit('upload', $this->parent->pathFull()));

			# Handle form

			if ($upload || $this->form->handle(new Filemanager\Controller\Create($this->parent), true)) {

				$query = (('' !== $this->parent->path()) ? ('?parent=' . $this->parent->path()) : '');

				Request::redirect(INSTALL_PATH . '/admin/content/filemanager' . $query);
			}

			# Get index

			$this->index = Number::forceInt(Request::get('index'), 1, 999999);

			# Get items

			$this->items = $this->getItems();

			# ------------------------

			return $this->getContents();
		}
	}
}
