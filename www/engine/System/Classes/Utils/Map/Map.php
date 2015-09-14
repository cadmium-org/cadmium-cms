<?php

namespace System\Utils {

	use Explorer;

	class Map {

		private $map = [];

		# Constructor

		public function __construct() {

			$file_name = (DIR_SYSTEM_DATA . 'Map.xml');

			if (false !== ($map_xml = Explorer::xml($file_name))) {

				foreach ($map_xml->item as $item) {

					$item = new Map\Item($item->path, $item->handler);

					if ($item->parsed()) $this->map[] = $item;
				}
			}
		}

		# Get handler by path

		public function handler(array $path) {

			foreach ($this->map as $item) {

				if (false !== ($handler = $item->handler($path))) return $handler;
			}

			# ------------------------

			return false;
		}
	}
}
