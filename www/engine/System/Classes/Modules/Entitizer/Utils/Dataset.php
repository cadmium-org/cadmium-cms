<?php

namespace Modules\Entitizer\Utils {

	use Modules\Entitizer;

	abstract class Dataset {

		protected $definition = null, $handlers = [], $data = [];

		# Add handler

		protected function addHandler(string $name, callable $handler) {

			if ((false !== $this->definition->param($name)) || isset($this->handlers[$name])) return;

			$this->handlers[$name] = $handler;
		}

		# Constructor

		public function __construct() {

			$this->definition = Entitizer::definition(static::$table);

			$this->init(); $this->reset();
		}

		# Reset data

		public function reset() {

			# Reset params

			foreach ($this->definition->params() as $name => $param) $this->data[$name] = $param->cast(null);

			# Reset extras

			foreach ($this->handlers as $name => $handler) $this->data[$name] = $handler($this->data);

			# Reset parent id

			if (static::$nesting) $this->data['parent_id'] = 0;

			# ------------------------

			return $this;
		}

		# Update data

		public function update(array $data) {

			# Update params

			foreach ($data as $name => $value) {

				if (false === ($param = $this->definition->param($name))) continue;

				$this->data[$name] = $param->cast($value);
			}

			# Update extras

			foreach ($this->handlers as $name => $handler) $this->data[$name] = $handler($this->data);

			# Update parent id

			if (static::$nesting && isset($data['parent_id'])) {

				$this->data['parent_id'] = $this->definition->param('id')->cast($data['parent_id']);
			}

			# ------------------------

			return $this;
		}

		# Cast data

		public function cast(array $data) {

			$cast = [];

			foreach ($data as $name => $value) {

				if (false === ($param = $this->definition->param($name))) continue;

				$cast[$name] = $param->cast($value);
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
