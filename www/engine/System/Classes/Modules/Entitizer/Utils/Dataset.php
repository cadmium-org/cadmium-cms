<?php

namespace Modules\Entitizer\Utils {

	use Modules\Entitizer;

	abstract class Dataset {

		protected $params = null, $workers = [], $data = [];

		# Add worker

		protected function addWorker(string $name, callable $worker) {

			if (isset($this->params[$name]) || isset($this->workers[$name])) return;

			$this->workers[$name] = $worker;
		}

		# Constructor

		public function __construct() {

			$this->params = Entitizer::definition(static::$table)->params();

			if (static::$nesting) $this->params['parent_id'] = $this->params['id'];

			$this->init(); $this->reset();
		}

		# Reset data

		public function reset() {

			# Reset params

			foreach ($this->params as $name => $param) $this->data[$name] = $param->cast(null);

			# Reset extras

			foreach ($this->workers as $name => $worker) $this->data[$name] = $worker($this->data);

			# ------------------------

			return $this;
		}

		# Update data

		public function update(array $data) {

			# Update params

			foreach ($data as $name => $value) {

				if (isset($this->params[$name])) $this->data[$name] = $this->params[$name]->cast($value);
			}

			# Update extras

			foreach ($this->workers as $name => $worker) $this->data[$name] = $worker($this->data);

			# ------------------------

			return $this;
		}

		# Cast data

		public function cast(array $data) {

			$cast = [];

			foreach ($data as $name => $value) {

				if (isset($this->params[$name])) $cast[$name] = $this->params[$name]->cast($value);
			}

			# ------------------------

			return $cast;
		}

		# Return data

		public function data() {

			return $this->data;
		}

		# Return param value

		public function get(string $name) {

			return ($this->data[$name] ?? null);
		}

		# Getter

		public function __get(string $name) {

			return ($this->data[$name] ?? null);
		}
	}
}
