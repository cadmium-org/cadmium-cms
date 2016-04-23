<?php

namespace {

	class Config {

		private $config = [], $values = [];

		# Add rule

		public function add(string $name, $default, callable $handler) {

			if ('' === $name) return;

			$this->config[$name] = $handler; $this->values[$name] = null;

			$this->set([$name => $default]);
		}

		# Set array of values

		public function set(array $data) {

			foreach ($data as $name => $value) {

				if (!isset($this->config[$name])) continue;

				try { $this->values[$name] = $this->config[$name]($value); }

				catch (\TypeError $e) { /* Ignore setting value of illegal type */ }
			}
		}

		# Cast array of values

		public function cast(array $data, bool $process_all = false) {

			$cast = [];

			foreach ($this->config as $name => $handler) {

				if (!($isset = isset($data[$name])) && !$process_all) continue;

				try { $cast[$name] = ($isset ? $handler($data[$name]) : $this->values[$name]); }

				catch (\TypeError $e) { $cast[$name] = $this->values[$name]; }
			}

			# ------------------------

			return $cast;
		}

		# Get value or array of values

		public function get(string $name = null) {

			if (null === $name) return $this->values;

			return ($this->values[$name] ?? null);
		}

		# Setter

		public function __set(string $name, $value) {

			return $this->set([$name => $value]);
		}

		# Getter

		public function __get(string $name) {

			return $this->get($name);
		}
	}
}
