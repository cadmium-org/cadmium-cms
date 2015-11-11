<?php

namespace DB\Utils {

	class Result {

		private $result = null, $query = '', $time = 0, $rows = 0, $id = 0, $error = '', $errno = 0;

		# Constructor

		public function __construct(\mysqli $link, $result, string $query, int $time) {

			$this->result       = $result;

			$this->query        = $query;

			$this->time         = $time;

			$this->rows         = mysqli_affected_rows($link);

			$this->id           = mysqli_insert_id($link);

			$this->error        = mysqli_error($link);

			$this->errno        = mysqli_errno($link);
		}

		# Getter

		public function __get(string $var) {

			return (isset($this->$var) ? $this->$var : null);
		}

		# Get next row

		public function row() {

			if (!is_object($this->result)) return null;

			return mysqli_fetch_assoc($this->result);
		}

		# Get rows array

		public function assoc() {

			if (!is_object($this->result)) return [];

			while (null !== ($row = $this->row())) yield $row;
		}
	}
}
