<?php

namespace DB\Utils {

	class Result {

		private $status = false, $result = null, $query = '', $time = 0;

		private $rows = 0, $id = 0, $error = '', $errno = 0;

		# Constructor

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

		# Getter

		public function __get(string $var) {

			return ($this->$var ?? null);
		}

		# Get next row

		public function row() {

			if (!is_object($this->result)) return null;

			return mysqli_fetch_assoc($this->result);
		}

		# Get rows array

		public function rows() {

			if (!is_object($this->result)) return [];

			$rows = []; while (null !== ($row = $this->row())) $rows[] = $row;

			# ------------------------

			return $rows;
		}
	}
}
