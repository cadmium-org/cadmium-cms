<?php

namespace DB\Utils {

	class Result {

		private $status, $result, $query, $time, $rows, $id, $error, $errno;

		# Constructor

		public function __construct($link, $result, $query, $time) {

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

		public function __get($var) {

			return (isset($this->$var) ? $this->$var : null);
		}

		# Get next row

		public function row() {

			if (!is_object($this->result)) return null;

			return mysqli_fetch_assoc($this->result);
		}

		# Get rows array

		public function assoc() {

			if (!is_object($this->result)) return array();

			$assoc = array();

			while (null !== ($row = $this->row())) $assoc[] = $row;

			# ------------------------

			return $assoc;
		}
	}
}
