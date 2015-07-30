<?php

namespace System\Utils\Map {

	use Warning, System, Arr, Explorer;

	class Map {

		const ERROR_FILE	= 'Unable to load map file';
		const ERROR_PARSE	= 'Unable to parse map';

		private $map = false;

		# Get parsed map

		private function getMap() {

			$file_name = (DIR_SYSTEM_DATA . 'Map.xml');

			if (false === ($map_xml = Explorer::xml($file_name))) throw new Warning\General(self::ERROR_FILE);

			$map = array();

			foreach ($map_xml->item as $item) {

				$item = new Item($item->path, $item->handler);

				if ($item->status()) $map[] = $item; else throw new Warning\General(self::ERROR_PARSE);
			}

			return $map;
		}

		# Get handler name by path

		private function getHandler($path) {

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

		public function handle($path) {

			$path = Arr::force($path);

			if (false !== ($handler = $this->getHandler($path))) {

				$handler = ('System\\Handlers\\' . $handler);

				return new $handler($path);
			}

			return new System\Handlers\Page($path);
		}
	}
}
