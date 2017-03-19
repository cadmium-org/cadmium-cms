<?php

/**
 * @package Cadmium\System\Modules\Entitizer
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Entitizer\Utils\Definition\Item {

	use Modules\Entitizer\Utils\Definition;

	class Foreign extends Definition\Item {

		protected $table = '', $field = '', $delete = null, $update = null;

		/**
		 * Validate an action value
		 *
		 * @return string|null : the action or null if the value is invalid
		 */

		private function validateAction(string $value) {

			$value = strtoupper($value); $range = ['CASCADE', 'RESTRICT', 'SET NULL'];

			return (in_array($value, $range, true) ? $value : null);
		}

		/**
		 * Constructor
		 */

		public function __construct(string $name, string $table, string $field, string $delete = null, string $update = null) {

			$this->name = $name; $this->table = $table; $this->field = $field;

			if (null !== $delete) $this->delete = $this->validateAction($delete);

			if (null !== $update) $this->update = $this->validateAction($update);
		}

		/**
		 * Get the statement
		 */

		public function getStatement() : string {

			return ("FOREIGN KEY (`" . $this->name . "`) REFERENCES `" . $this->table . "` (`" . $this->field . "`)") .

				   ((null !== $this->delete) ? (" ON DELETE " . $this->delete) : "") .

				   ((null !== $this->update) ? (" ON UPDATE " . $this->update) : "");
		}
	}
}
