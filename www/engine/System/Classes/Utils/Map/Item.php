<?php

namespace System\Utils\Map {

	class Item {

		private $path = [], $handler = [], $parsed = false;

		# Parse string

		private function parse($string, $regexp) {

			if (!preg_match('/^\/(.*)$/', $string, $matches)) return false;

			$items = preg_split('/\//', $matches[1], 0, PREG_SPLIT_NO_EMPTY); $parsed = [];

			foreach ($items as $name) if (preg_match($regexp, $name)) $parsed[] = $name; else return false;

			# ------------------------

			return $parsed;
		}

		# Constructor

		public function __construct($path, $handler) {

			$path = strval($path); $handler = strval($handler);

			if (false !== ($path = $this->parse($path, REGEX_MAP_PATH_ITEM_NAME))) $this->path = $path;

			if (false !== ($handler = $this->parse($handler, REGEX_MAP_HANDLER_ITEM_NAME))) $this->handler = $handler;

			$this->parsed = ((false !== $path) && (false !== $handler));
		}

		# Get handler by path

		public function handler(array $path) {

			if (!$this->parsed) return false;

			if ($path !== $this->path) return false;

			# ------------------------

			return implode('\\', $this->handler);
		}

		# Check if parsed

		public function parsed() {

			return $this->parsed;
		}
	}
}
