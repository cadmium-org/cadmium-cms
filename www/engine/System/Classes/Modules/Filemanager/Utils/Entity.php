<?php

namespace Modules\Filemanager\Utils {

	use Explorer;

	abstract class Entity {

		private $parent = null, $name = '', $path = '', $path_full = '';

		# Get item protorype

		private function getPrototype(string $name) {

			if (preg_match('/[\/\\\\]/', $name)) return false;

			$path = (($this->parent->path() ? ($this->parent->path() . '/') : '') . $name);

			$path_full = ($this->parent->pathFull() . $name);

			# ------------------------

			return ['name' => $name, 'path' => $path, 'path_full' => $path_full];
		}

		# Constructor

		public function __construct(Container $parent, string $name = '') {

			$this->parent = $parent; $this->init($name);
		}

		# Init item

		public function init(string $name) {

			if (false === ($prototype = $this->getPrototype($name))) return false;

			if (!Explorer::{static::$checker}($prototype['path_full'])) return false;

			foreach ($prototype as $var => $value) $this->$var = $value;

			# ------------------------

			return true;
		}

		# Create item

		public function create(string $name) {

			if (('' !== $this->name) || (false === ($prototype = $this->getPrototype($name)))) return false;

			if (!Explorer::{static::$creator}($prototype['path_full'])) return false;

			foreach ($prototype as $var => $value) $this->$var = $value;

			# ------------------------

			return true;
		}

		# Rename item

		public function rename(string $name) {

			if (('' === $this->name) || (false === ($prototype = $this->getPrototype($name)))) return false;

			if (!@rename($this->path_full, $prototype['path_full'])) return false;

			foreach ($prototype as $var => $value) $this->$var = $value;

			# ------------------------

			return true;
		}

		# Remove item

		public function remove() {

			if ('' === $this->name) return false;

			if (!Explorer::{static::$remover}($this->path_full, true)) return false;

			$this->name = ''; $this->path = ''; $this->path_full = '';

			# ------------------------

			return true;
		}

		# Return type

		public function type() {

			return static::$type;
		}

		# Return parent

		public function parent() {

			return $this->parent;
		}

		# Return name

		public function name() {

			return $this->name;
		}

		# Return path

		public function path() {

			return $this->path;
		}

		# Return full path

		public function pathFull() {

			return $this->path_full;
		}
	}
}
