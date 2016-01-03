<?php

namespace System\Utils {

	use Explorer, Url;

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

		# Get handler by url

		public function handler(Url $url) {

			foreach ($this->map as $item) {

				if (false !== ($handler = $item->handler($url->path()))) return $handler;
			}

			# ------------------------

			return false;
		}
	}
}
