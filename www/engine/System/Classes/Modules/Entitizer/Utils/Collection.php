<?php

namespace Modules\Entitizer\Utils {

	use Modules\Entitizer, Config;

	abstract class Collection {

		protected $definition = null, $config = null;

		# Cast order set to be suitable with entity definition

		private function castOrderBy(array $data) {

			$order_by = [];

			foreach ($data as $field => $direction) {

				if (false === ($param = $this->definition->param($field))) continue;

				$order_by[$param->name] = ((strtoupper($direction) !== 'DESC') ? 'ASC' : 'DESC');
			}

			# ------------------------

			return (([] !== $order_by) ? $order_by : static::$order_by);
		}

		# Get selection

		protected function getSelection() {

			$selection = [];

			foreach ($this->definition->paramsSecure() as $field) $selection[] = ('ent.' . $field);

			# ------------------------

			return implode(', ', $selection);
		}

		# Get order by

		protected function getOrderBy(array $data) {

			$order_by = [];

			foreach ($this->castOrderBy($data) as $field => $direction) $order_by[] = ('ent.' . $field . ' ' . $direction);

			# ------------------------

			return implode(', ', $order_by);
		}

		# Get condition

		protected function getCondition(array $data) {

			return implode(' AND ', array_filter($this->config->cast($data, true)));
		}

		# Constructor

		public function __construct() {

			$this->definition = Entitizer::definition(static::$table);

			$this->config = new Config();

			$this->init();
		}
	}
}
