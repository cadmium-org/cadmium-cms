<?php

namespace System\Utils\Map {

	class Item {

		private $path = [], $handler = [], $parsed = false;

		# Parse string

		private function parse(string $string, string $regex) {

			if (!preg_match('/^\//', $string)) return false;

			$items = preg_split('/\//', $string, 0, PREG_SPLIT_NO_EMPTY);

			foreach ($items as $name) if (!preg_match($regex, $name)) return false;

			# ------------------------

			return $items;
		}

		# Constructor

		public function __construct(string $path, string $handler) {

			if (false !== ($path = $this->parse($path, REGEX_MAP_PATH_ITEM_NAME))) $this->path = $path;

			if (false !== ($handler = $this->parse($handler, REGEX_MAP_HANDLER_ITEM_NAME))) $this->handler = $handler;

			$this->parsed = ((false !== $path) && (false !== $handler));
		}

		# Get handler by path

		public function handler(array $path) {

			if (!$this->parsed || ($path !== $this->path)) return false;

			return implode('\\', $this->handler);
		}

		# Check if parsed

		public function parsed() {

			return $this->parsed;
		}
	}
}
