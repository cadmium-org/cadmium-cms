<?php

namespace {

	abstract class DB {

		private static $link = false, $last = null, $log = [], $time = 0;

		# Connect to database

		public static function connect(string $server, string $user, string $password, string $name) {

			# Establish connection

			if (false === ($link = @mysqli_connect($server, $user, $password))) throw new Exception\DBConnect();

			# Select database

			if (!@mysqli_select_db($link, $name)) throw new Exception\DBSelect();

			# Set encoding

			if (!@mysqli_query($link, "SET character_set_client = 'utf8'")) throw new Exception\DBCharset();

			if (!@mysqli_query($link, "SET character_set_results = 'utf8'")) throw new Exception\DBCharset();

			if (!@mysqli_query($link, "SET collation_connection = 'utf8_general_ci'")) throw new Exception\DBCharset();

			# ------------------------

			self::$link = $link;
		}

		# Send new query

		public static function send(string $query) {

			if (false === self::$link) return (self::$last = false);

			$time = microtime(true); $result = mysqli_query(self::$link, $query); $time = (microtime(true) - $time);

			self::$log[] = (self::$last = new DB\Utils\Result(self::$link, $result, $query, $time)); self::$time += $time;

			# ------------------------

			return self::$last;
		}

		# Generate & send select query

		public static function select(string $table, $selection, $condition = null, $order = null, int $limit = 0) {

			$query = new DB\Query\Select($table, $selection, $condition, $order, $limit);

			return self::send($query->query());
		}

		# Generate & send insert query

		public static function insert(string $table, array $dataset, bool $multiple = false) {

			$query = new DB\Query\Insert($table, $dataset, $multiple);

			return self::send($query->query());
		}

		# Generate & send update query

		public static function update(string $table, array $dataset, $condition = null) {

			$query = new DB\Query\Update($table, $dataset, $condition);

			return self::send($query->query());
		}

		# Generate & send delete query

		public static function delete(string $table, $condition = null) {

			$query = new DB\Query\Delete($table, $condition);

			return self::send($query->query());
		}

		# Return last query holder

		public static function last() {

			return self::$last;
		}

		# Encode search value

		public static function encodeSearchValue(string $value, bool $add_slashes = true) {

			$value = str_replace(' ', '%', str_replace(['%', '_'], ['\%', '\_'], $value));

			return ($add_slashes ? addslashes($value) : $value);
		}

		# Get process log

		public static function log() {

			$log = [];

			foreach (self::$log as $result) {

				$status = $result->status; $query = $result->query; $time = number_format($result->time, 10);

				$summary = ($status ? ($result->rows . ' row(s)') : ('(' . $result->errno . ') ' . $result->error));

				$log[] = ['status' => $status, 'query' => $query, 'time' => $time, 'summary' => $summary];
			}

			# ------------------------

			return $log;
		}

		# Get process time

		public static function time() {

			return number_format(self::$time, 10);
		}
	}
}
