<?php

namespace {

	class Url {

		private $path = array(), $query = array();

		# Consructor

		public function __construct($url = '') {

			$url = strval($url);

			if (false === ($url = parse_url($url))) return;

			# Parse path

			if (isset($url['path'])) foreach (explode('/', $url['path']) as $item) {

				if ('' !== $item) $this->path[] = urldecode($item);
			}

			# Parse query

			if (isset($url['query'])) parse_str($url['query'], $this->query);
		}

		# Return path

		public function path() {

			return $this->path;
		}

		# Return query

		public function query() {

			return $this->query;
		}

		# Set query variable

		public function set($name, $value) {

			$name = strval($name); $value = strval($value);

			$this->query[$name] = $value;
		}

		# Get url as string

		public function get() {

			$path = array();

			foreach ($this->path as $value) $path[] = urlencode($value);

			$path = implode('/', $path); $query = http_build_query($this->query);

			# ------------------------

			return ('/' . $path . ($query ? ('?' . $query) : ''));
		}
	}
}
