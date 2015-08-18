<?php

namespace System\Utils\Entitizer {

    use System\Utils\Entitizer, DB;

	abstract class Entity {

		protected $type = '', $table = '', $params = null;

		protected $init = false, $id = 0, $data = array();

        # Get dataset

		private function getDataset(Params $params, array $data, $initial = false) {

			$set = array();

            if ($initial && ($this instanceof Utils\Type\Extension)) $set['id'] = $this->id;

			foreach ($params->get() as $name => $param) {

				if (isset($data[$name])) $set[$name] = $param->set($data[$name]);
			}

			return $set;
		}

        # Init entity

        protected function init($name, $value) {

            if ($this->init) return true;

            # Select entity from DB

			$selection = array_merge(array('id'), array_keys($this->params->get()));

			DB::select($this->table, $selection, array($name => $value), null, 1);

			if (!(DB::last() && (DB::last()->rows === 1))) return false;

			$data = DB::last()->row();

			# Validate data

			$this->id = $this->params->id()->set($data['id']);

			foreach ($this->params->get() as $name => $param) $this->data[$name] = $param->set($data[$name]);

			# Implement entity

			$this->implement();

			# Cache entity

			Entitizer::cache($this);

			# ------------------------

			return ($this->init = true);
		}

        # Constructor

		public function __construct() {

            # Create params object

			$this->params = new Params($this instanceof Utils\Type\General);

            # Add parent id param

            $nesting = ($this instanceof Utils\Type\Nesting);

            if ($nesting) $this->params->relation('parent_id', $this->type);

            # Define entity

            $this->define();
		}

        # Create table

		public function createTable() {

            $set = array_merge($this->params->fieldset(), $this->params->keyset());

            $query = ("CREATE TABLE IF NOT EXISTS `" . $this->table . "`") .

                     ("(" . implode(", ", $set) . ") ENGINE=InnoDB DEFAULT CHARSET=utf8");

            # ------------------------

            return (DB::send($query) && DB::last()->status);
		}

        # Create entity

		public function create(array $data) {

            if ($this->init) return true;

            # Create temporary params instance

			$params = clone $this->params;

			$set = $this->getDataset($params, $data, true);

			# Insert entity

			DB::insert($this->table, $set);

			if (!(DB::last() && DB::last()->status)) return false;

			# Re-init entity

			$this->params = $params; $this->id = DB::last()->id;

			foreach ($set as $name => $value) $this->data[$name] = $value;

            # Implement entity

			$this->implement();

			# ------------------------

			return ($this->init = true);
		}

		# Edit entity

		public function edit(array $data) {

            if (!$this->init) return false;

            # Create temporary params instance

			$params = clone $this->params;

			$set = $this->getDataset($params, $data);

			# Update entity

			DB::update($this->table, $set, array('id' => $this->id));

			if (!(DB::last() && DB::last()->status)) return false;

			# Re-init entity

			$this->params = $params;

			foreach ($set as $name => $value) $this->data[$name] = $value;

            # Implement entity

			$this->implement();

			# ------------------------

			return true;
		}

		# Remove entity

		public function remove() {

			if (!$this->init) return false;

			# Remove entity

			DB::delete($this->table, array('id' => $this->id));

			if (!(DB::last() && DB::last()->status)) return false;

			$this->id = 0; $this->data = array();

			# ------------------------

			return true;
		}

        # Get relation

        public function relation($name) {

            if (!$this->init) return false;

            $name = strval($name);

			if (false === ($param = $this->params->get($name))) return false;

			if (!($param instanceof Entitizer\Param\Relation)) return false;

            # ------------------------

			return $param->entity;
        }

        # Return data

		public function __get($name) {

			$name = strval($name);

			if ($name === 'id') return $this->id;

			return (isset($this->data[$name]) ? $this->data[$name] : null);
		}

        # Definer interface

		abstract protected function define();

		# Implementor interface

		abstract protected function implement();
	}
}
