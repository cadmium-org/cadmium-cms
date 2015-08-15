<?php

namespace System\Utils {

	use Error, System, Explorer;

	class Map {

		const ERROR_FILE	= 'Unable to load map file';
		const ERROR_PARSE	= 'Unable to parse map';

		private $map = null;

		# Get parsed map

		private function getMap() {

			$file_name = (DIR_SYSTEM_DATA . 'Map.xml');

			if (false === ($map_xml = Explorer::xml($file_name))) throw new Error\General(self::ERROR_FILE);

			$map = array();

			foreach ($map_xml->item as $item) {

				$item = new Map\Item($item->path, $item->handler);

				if ($item->parsed()) $map[] = $item; else throw new Error\General(self::ERROR_PARSE);
			}

			return $map;
		}

		# Get handler name by path

		private function getHandler(array $path) {

			foreach ($this->map as $item) {

				if (false !== ($handler = $item->handler($path))) return $handler;
			}

			return false;
		}

		# Constructor

		public function __construct() {

			$this->map = $this->getMap();
		}

		# Get handler object by path

		public function handle(array $path) {

			if (false !== ($handler = $this->getHandler($path))) {

				$handler = ('System\\Handlers\\' . $handler);

				return new $handler($path);
			}

			return new System\Handlers\Site\Page($path);
		}
	}
}
