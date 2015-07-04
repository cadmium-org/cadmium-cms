<?php

namespace {

	class Url {

		private $path = array(), $query = array();

		# Consructor

		public function __construct($url) {

			$url = String::validate($url);

			if (false === ($url = parse_url($url))) return;

			if (isset($url['path'])) foreach (explode('/', $url['path']) as $item) {

				if ('' !== $item) $this->path[] = urldecode($item);
			}

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

			$name = String::validate($name); $value = String::validate($value);

			$this->query[$name] = $value;

			# ------------------------

			return true;
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

?>
