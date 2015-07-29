<?php

namespace DB\Result {

	use DB\Utils;

	class Select extends Utils\Result {

		# Constructor

		public function __construct($query, $result, $time) {

			$this->status       = true;

			$this->query        = $query;

			$this->result       = $result;

			$this->time         = $time;

			$this->rows         = mysqli_num_rows($result);
		}

		# Get next row

		public function row() {

			return mysqli_fetch_assoc($this->result);
		}

		# Get rows array

		public function assoc() {

			$assoc = array();

			while (null !== ($row = $this->row())) $assoc[] = $row;

			# ------------------------

			return $assoc;
		}
	}
}
