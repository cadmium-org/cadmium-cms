<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Utils {

	use Modules\Entitizer, Dataset as Config;

	abstract class Collection {

		protected $definition = null, $config = null;

		/**
		 * Validate an order-by fieldset to be suitable with the entity definition
		 *
		 * @return array : the array of validated values or the array of defaults if the validation result is empty
		 */

		private function castOrderBy(array $data) : array {

			$order_by = [];

			foreach ($data as $field => $direction) {

				if (false === ($param = $this->definition->getParam($field))) continue;

				$order_by[$param->name] = ((strtoupper($direction) !== 'DESC') ? 'ASC' : 'DESC');
			}

			# ------------------------

			return (([] !== $order_by) ? $order_by : static::$order_by);
		}

		/**
		 * Get the selection statement
		 */

		protected function getSelection() : string {

			$selection = [];

			foreach ($this->definition->getParamsSecure() as $field) $selection[] = ('ent.' . $field);

			# ------------------------

			return implode(', ', $selection);
		}

		/**
		 * Get the order-by statement
		 */

		protected function getOrderBy(array $data) : string {

			$order_by = [];

			foreach ($this->castOrderBy($data) as $field => $direction) $order_by[] = ('ent.' . $field . ' ' . $direction);

			# ------------------------

			return implode(', ', $order_by);
		}

		/**
		 * Get the condition statement
		 */

		protected function getCondition(array $data) : string {

			return implode(' AND ', array_filter($this->config->castArray($data, true)));
		}

		/**
		 * Constructor
		 */

		public function __construct() {

			$this->definition = Entitizer::getDefinition(static::$table);

			$this->config = new Config;

			$this->init();
		}
	}
}
