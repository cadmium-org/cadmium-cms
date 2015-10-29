<?php

namespace System\Modules\Filemanager\Handler {

	use System\Utils\Pagination, System\Utils\View, Request, Explorer, Mime, Number, Template, Url;

	class Uploads {

		private $index = 0, $dir = '', $items = [];

		# Validate dir name

		private function getDir() {

			$dir = array_filter(preg_split('/[\/\\\\]/', Request::get('dir')), 'strlen'); $validated = [];

			foreach ($dir as $name) if (!in_array($name, ['', '.', '..'], true)) $validated[] = $name;

			$validated = implode('/', $validated);

			# ------------------------

			return (Explorer::isDir(DIR_UPLOADS . $validated) ? $validated : '');
		}

		# Get items

		private function getItems() {

			$dir = (DIR_UPLOADS . $this->dir); $dirs = []; $files = [];

			# Read directory contents

			$handler = opendir($dir);

			while (false !== ($name = readdir($handler))) {

				if (($name === '.') || ($name === '..') || ($name === '.empty')) continue;

				$filename = ($dir . '/' . $name);

				if (is_file($filename)) $files[] = ['name' => $name, 'is_file' => true, 'size' => filesize($filename)];

				else if (is_dir($filename)) $dirs[] = ['name' => $name, 'is_file' => false, 'size' => ''];
			}

			closedir($handler);

			# Extract a set of items to display

			$list = array_merge($dirs, $files); $total = count($list);

			$list = array_splice($list, (($this->index - 1) * CONFIG_ADMIN_FILES_DISPLAY), CONFIG_ADMIN_FILES_DISPLAY);

			# ------------------------

			return ['list' => $list, 'total' => $total];
		}

		# Get path

		private function getPath() {

			$dir = []; $path = [];

			if ('' !== $this->dir) foreach (explode('/', $this->dir) as $name) {

				$dir[] = $name; $path[] = ['dir' => implode('/', $dir), 'name' => $name];
			}

			# ------------------------

			return $path;
		}

		# Get icon by file extension

		private function getIcon($filename) {

			$extension = strtolower(Explorer::extension($filename, false));

			if (Mime::isImage($extension)) return 'file image outline';

			else if (Mime::isAudio($extension)) return 'file audio outline';

			else if (Mime::isVideo($extension)) return 'file video outline';

			else if (in_array($extension, ['doc', 'docx'], true)) return 'file word outline';

			else if (in_array($extension, ['xls', 'xlsx'], true)) return 'file excel outline';

			else if (in_array($extension, ['ppt', 'pptx'], true)) return 'file powerpoint outline';

			else if ($extension === 'pdf') return 'file pdf outline';

			# ------------------------

			return 'file outline';
		}

		# Get directory item block

		private function getDirItemBlock($item) {

			$view = View::get('Blocks\Filemanager\Item\Dir');

			$view->dir = (($this->dir ? ($this->dir . '/') : '') . $item['name']);

			$view->name = $item['name'];

			# ------------------------

			return $view;
		}

		# Get file item block

		private function getFileItemBlock($item) {

			$view = View::get('Blocks\Filemanager\Item\File');

			$view->icon = $this->getIcon($item['name']);

			$view->file = (($this->dir ? ($this->dir . '/') : '') . $item['name']);

			$view->name = $item['name']; $view->size = Number::size($item['size']);

			# ------------------------

			return $view;
		}

		# Get items block

		private function getItemsBlock() {

			$items = Template::group();

			foreach ($this->items['list'] as $item) {

				$items->add($item['is_file'] ? $this->getFileItemBlock($item) : $this->getDirItemBlock($item));
			}

			# ------------------------

			return $items;
		}

		# Get pagination block

		private function getPaginationBlock() {

			$query = (('' !== $this->dir) ? ('?dir=' . $this->dir) : '');

			$url = new Url(INSTALL_PATH . '/admin/content/filemanager' . $query);

			# ------------------------

			return Pagination::block($this->index, CONFIG_ADMIN_FILES_DISPLAY, $this->items['total'], $url);
		}

		# Get contents

		private function getContents() {

			$contents = View::get('Blocks\Filemanager\Main');

			# Set path

			$contents->path = $this->getPath();

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

			$this->index = Number::format(Request::get('index'), 1, 999999);

			$this->dir = $this->getDir();

			$this->items = $this->getItems();

			# ------------------------

			return $this->getContents();
		}
	}
}
