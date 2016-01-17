<?php

namespace Utils {

	use Arr, Explorer, Url;

	class Map {

		private $map = [];

		# Parse string

		private function parseString(string $string, string $regex) {

			$parts = preg_split('/\//', $string, 0, PREG_SPLIT_NO_EMPTY);

			foreach ($parts as $name) if (!preg_match($regex, $name)) return false;

			# ------------------------

			return $parts;
		}

		# Parse item

		private function parseItem(array $item) {

			$data = Arr::select($item, ['path', 'handler']);

			if (false === ($path = $this->parseString($data['path'], REGEX_MAP_ITEM_PATH))) return;

			if (false === ($handler = $this->parseString($data['handler'], REGEX_MAP_ITEM_HANDLER))) return;

			$this->map[] = ['path' => $path, 'handler' => implode('\\', $handler)];
		}

		# Constructor

		public function __construct() {

			$file_name = (DIR_SYSTEM_DATA . 'Map.json');

			if (false === ($map = Explorer::json($file_name))) return;

			foreach ($map as $item) if (is_array($item)) $this->parseItem($item);
		}

		# Get handler by url

		public function handler(Url $url) {

			foreach ($this->map as $item) if ($item['path'] === $url->path()) return $item['handler'];

			return false;
		}
	}
}
