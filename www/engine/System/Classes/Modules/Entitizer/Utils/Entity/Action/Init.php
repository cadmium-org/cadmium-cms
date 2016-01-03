<?php

namespace System\Modules\Entitizer\Utils\Entity\Action {

	use DB;

	trait Init {

		protected $definition = null, $error = false, $id = 0, $data = [];

		# Init entity

		public function init($value, string $name = 'id') {

			if (0 !== $this->id) return false;

			# Check param name

			if ($name === 'id') $param = $this->definition->id();

			else if ((false === ($param = $this->definition->get($name))) || !$param->unique()) return false;

			# Select entity from DB

			$selection = array_merge(['id'], array_keys($this->definition->params()));

			$name = $param->name(); $value = $param->cast($value);

			DB::select(static::$table, $selection, [$name => $value], null, 1);

			if (($this->error = !(DB::last() && DB::last()->status)) || (DB::last()->rows !== 1)) return false;

			$data = DB::last()->row();

			# Cast data

			$this->id = $this->definition->id()->cast($data['id']);

			foreach ($this->definition->params() as $name => $param) $this->data[$name] = $param->cast($data[$name]);

			# Init path

			if (static::$nesting) $this->data['path'] = $this->getPath();

			# Implement entity

			$this->implement();

			# Cache entity

			self::$cache[static::$type][$this->id] = $this;

			# ------------------------

			return true;
		}

		# Get path interface

		abstract protected function getPath();

		# Implementor interface

		abstract protected function implement();
	}
}
