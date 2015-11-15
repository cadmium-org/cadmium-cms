<?php

namespace {

	class Url {

		private $path = [], $query = [];

		# Consructor

		public function __construct(string $url = '') {

			if (false === ($url = parse_url($url))) return;

			# Parse path

			if (isset($url['path'])) foreach (explode('/', $url['path']) as $part) {

				if ('' !== $part) $this->path[] = urldecode($part);
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

		public function set(string $name, string $value) {

			$this->query[$name] = $value;

			return $this;
		}

		# Get url as string

		public function get() {

			$path = [];

			foreach ($this->path as $value) $path[] = urlencode($value);

			$path = implode('/', $path); $query = http_build_query($this->query);

			# ------------------------

			return ('/' . $path . ($query ? ('?' . $query) : ''));
		}
	}
}
