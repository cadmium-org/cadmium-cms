<?php

/**
 * @package Cadmium\System\Modules\Filemanager
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Filemanager\Utils {

	use Explorer;

	class Entity {

		private $parent = null, $name = '', $path = '', $path_full = '', $type = '';

		/**
		 * Get entity prototype data
		 *
		 * @return array|false : the data array or false if the name is invalid
		 */

		private function getPrototype(string $name) {

			if (('' === $name) || preg_match('/[\/\\\\]/', $name)) return false;

			if ($this->parent->isIgnoreHidden() && preg_match('/^\./', $name)) return false;

			$path = (($this->parent->getPath() ? ($this->parent->getPath() . '/') : '') . $name);

			$path_full = ($this->parent->getPathFull() . $name);

			# ------------------------

			return ['name' => $name, 'path' => $path, 'path_full' => $path_full];
		}

		/**
		 * Constructor
		 */

		public function __construct(Container $parent, string $name = '') {

			$this->parent = $parent; $this->init($name);
		}

		/**
		 * Initialize the entity by a directory/file name
		 *
		 * @return bool : true on success or false if a corresponding directory/file does not exist
		 */

		public function init(string $name) : bool {

			if (false === ($prototype = $this->getPrototype($name))) return false;

			# Check type

			$type = Explorer::getType($prototype['path_full']);

			if (!in_array($type, ['dir', 'file'], true)) return false;

			# Set data

			foreach ($prototype as $var => $value) $this->$var = $value;

			$this->type = $type;

			# ------------------------

			return true;
		}

		/**
		 * Check whether another entity with a given name exists in the same parent directory.
		 * This method is useful to find out is it possible to create or rename the entity
		 *
		 * @return bool : true if the check has been successful and no other items with the given name found, otherwise false
		 */

		public function check(string $name) : bool {

			if (false === ($prototype = $this->getPrototype($name))) return false;

			if (($name !== $this->name) && Explorer::exists($prototype['path_full'])) return false;

			# ------------------------

			return true;
		}

		/**
		 * Create the entity
		 *
		 * @return bool : true on success or false on failure
		 */

		public function create(string $name, string $type) : bool {

			if (('' !== $this->name) || (false === ($prototype = $this->getPrototype($name)))) return false;

			if (!in_array($type, ['dir', 'file'], true)) return false;

			# Create entity

			$create = (($type === 'dir') ? 'createDir' : 'createFile');

			if (!Explorer::$create($prototype['path_full'])) return false;

			# Set data

			foreach ($prototype as $var => $value) $this->$var = $value;

			$this->type = $type;

			# ------------------------

			return true;
		}

		/**
		 * Rename the entity
		 *
		 * @return bool : true on success or false on failure
		 */

		public function rename(string $name) : bool {

			if (('' === $this->name) || (false === ($prototype = $this->getPrototype($name)))) return false;

			# Rename entity

			if (!Explorer::rename($this->path_full, $prototype['path_full'])) return false;

			# Set data

			foreach ($prototype as $var => $value) $this->$var = $value;

			# ------------------------

			return true;
		}

		/**
		 * Remove the entity
		 *
		 * @return bool : true on success or false on failure
		 */

		public function remove() : bool {

			if ('' === $this->name) return false;

			# Remove entity

			$remove = (($this->type === 'dir') ? 'removeDir' : 'removeFile');

			if (!Explorer::$remove($this->path_full, true)) return false;

			# Reset data

			$this->name = ''; $this->path = ''; $this->path_full = ''; $this->type = '';

			# ------------------------

			return true;
		}

		/**
		 * Get the entity extension in lower case
		 *
		 * @return string|false : the extension or false on failure
		 */

		public function getExtension() {

			if ('' === $this->name) return false;

			return strtolower(Explorer::getExtension($this->name, false));
		}

		/**
		 * Get the entity creation time
		 *
		 * @return int|false : the time or false on failure
		 */

		public function getCreated() {

			if ('' === $this->name) return false;

			return Explorer::getCreated($this->path_full);
		}

		/**
		 * Get the entity access time
		 *
		 * @return int|false : the time or false on failure
		 */

		public function getAccessed() {

			if ('' === $this->name) return false;

			return Explorer::getAccessed($this->path_full);
		}

		/**
		 * Get the entity modification time
		 *
		 * @return int|false : the time or false on failure
		 */

		public function getModified() {

			if ('' === $this->name) return false;

			return Explorer::getModified($this->path_full);
		}

		/**
		 * Get the entity permissions
		 *
		 * @return int|false : the permissions or false on failure
		 */

		public function getPermissions() {

			if ('' === $this->name) return false;

			return Explorer::getPermissions($this->path_full);
		}

		/**
		 * Get the entity size
		 *
		 * @return int|false : the size or false on failure
		 */

		public function getSize() {

			if ('' === $this->name) return false;

			return Explorer::getSize($this->path_full);
		}

		/**
		 * Get the file contents
		 *
		 * @return string|false : the read data or false on failure
		 */

		public function getContents() {

			if ('' === $this->name) return false;

			return Explorer::getContents($this->path_full);
		}

		/**
		 * Save data into the file
		 *
		 * @return int|false : the number of bytes that were written to the file or false on failure
		 */

		public function putContents(string $contents) {

			if ('' === $this->name) return false;

			return Explorer::putContents($this->path_full, $contents);
		}

		/**
		 * Check if the entity has been successfully initialized
		 */

		public function isInited() : bool {

			return ('' !== $this->name);
		}

		/**
		 * Check if the entity is a directory
		 */

		public function isDir() : bool {

			return ($this->type === 'dir');
		}

		/**
		 * Check if the entity is a file
		 */

		public function isFile() : bool {

			return ($this->type === 'file');
		}

		/**
		 * Get the entity parent
		 */

		public function getParent() : Container {

			return $this->parent;
		}

		/**
		 * Get the entity name
		 */

		public function getName() : string {

			return $this->name;
		}

		/**
		 * Get the entity relative path
		 */

		public function getPath() : string {

			return $this->path;
		}

		/**
		 * Get the entity full path
		 */

		public function getPathFull() : string {

			return $this->path_full;
		}

		/**
		 * Get the entity type
		 */

		public function getType() : string {

			return $this->type;
		}
	}
}
