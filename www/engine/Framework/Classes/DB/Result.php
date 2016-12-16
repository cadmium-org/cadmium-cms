<?php

/**
 * @package Cadmium\Framework\DB
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace DB {

	class Result {

		/**
		 * @property  bool                $status     the result status
		 * @property  mysqli_result|bool  $result     the mysqli_result object for successful select queries, true for other queries, or false on failure
		 * @property  string              $query      the query string
		 * @property  float               $time       the query execution time in seconds
		 *
		 * @property  int                 $rows       a number of selected/affected rows
		 * @property  int                 $id         an updated id (auto-increment field) or zero if the id were not affected
		 * @property  string              $error      an error description or an empty string if no error occurred
		 * @property  int                 $errno      an error code or zero if no error occurred
		 */

		private $status = false, $result = null, $query = '', $time = 0.0;

		private $rows = 0, $id = 0, $error = '', $errno = 0;

		/**
		 * Constructor
		 */

		public function __construct(\mysqli $link, $result, string $query, float $time) {

			$this->status       = (false !== $result);

			$this->result       = $result;

			$this->query        = $query;

			$this->time         = $time;

			$this->rows         = mysqli_affected_rows($link);

			$this->id           = mysqli_insert_id($link);

			$this->error        = mysqli_error($link);

			$this->errno        = mysqli_errno($link);
		}

		/**
		 * Get the next row
		 *
		 * @return array|null : the row data array or null if there are no more rows in the resultset
		 */

		public function getRow() {

			if (!is_object($this->result)) return null;

			return mysqli_fetch_assoc($this->result);
		}

		/**
		 * Get the rows array
		 */

		public function getRows() : array {

			if (!is_object($this->result)) return [];

			$rows = []; while (null !== ($row = $this->getRow())) $rows[] = $row;

			# ------------------------

			return $rows;
		}

		/**
		 * Get a property
		 */

		public function __get(string $property) {

			return ($this->$property ?? null);
		}

		/**
		 * Check if a property exists
		 */

		public function __isset(string $property) : bool {

			return isset($this->$property);
		}
	}
}
