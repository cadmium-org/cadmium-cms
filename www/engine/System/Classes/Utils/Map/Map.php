<?php

namespace System\Utils {

	use System, Explorer;

	class Map {

		private $map = array();

		# Get handler name by path

		private function getHandler(array $path) {

			foreach ($this->map as $item) {

				if (false !== ($handler = $item->handler($path))) return $handler;
			}

			return false;
		}

		# Constructor

		public function __construct() {

			$file_name = (DIR_SYSTEM_DATA . 'Map.xml');

			if (false !== ($map_xml = Explorer::xml($file_name))) foreach ($map_xml->item as $item) {

				$item = new Map\Utils\Item($item->path, $item->handler);

				if ($item->parsed()) $this->map[] = $item;
			}
		}

		# Get handler object by path

		public function handle(array $path) {

			$handler = $this->getHandler($path);

			$class = ((false !== $handler) ? ('System\Handlers\\' . $handler) : 'System\Handlers\Site\Page');

			# ------------------------

			return new $class($path);
		}
	}
}
