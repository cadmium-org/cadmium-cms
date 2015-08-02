<?php

namespace {

	abstract class DB {

		private static $link = false, $last = null, $log = array(), $time = 0;

		# Connect to database

		public static function connect($server, $user, $password, $name) {

			$server = strval($server); $user = strval($user); $password = strval($password); $name = strval($name);

			# Establish connection

			if (false === ($link = @mysqli_connect($server, $user, $password))) throw new Error\DBConnect();

			# Select database

			if (!@mysqli_select_db($link, $name)) throw new Error\DBSelect();

			# Set encoding

			if (!@mysqli_query($link, "SET character_set_client = 'utf8'")) throw new Error\DBCharset();

			if (!@mysqli_query($link, "SET character_set_results = 'utf8'")) throw new Error\DBCharset();

			if (!@mysqli_query($link, "SET collation_connection = 'utf8_general_ci'")) throw new Error\DBCharset();

			# ------------------------

			self::$link = $link;
		}

		# Send new query

		public static function send($query) {

			if (false === self::$link) return false;

			$query = strval($query);

			$time = microtime(true); $result = mysqli_query(self::$link, $query); $time = (microtime(true) - $time);

			$holder = new DB\Utils\Result(self::$link, $result, $query, $time);

			self::$last = $holder; self::$log[] = $holder; self::$time += $time;

			# ------------------------

			return $holder;
		}

		# Generate & send select query

		public static function select($table, $selection, $condition = null, $order = null, $limit = 0) {

			$query = new DB\Query\Select($table, $selection, $condition, $order, $limit);

			# ------------------------

			return self::send($query->query());
		}

		# Generate & send insert query

		public static function insert($table, array $dataset, $multiple = false) {

			$query = new DB\Query\Insert($table, $dataset, $multiple);

			# ------------------------

			return self::send($query->query());
		}

		# Generate & send update query

		public static function update($table, array $dataset, $condition = null) {

			$query = new DB\Query\Update($table, $dataset, $condition);

			# ------------------------

			return self::send($query->query());
		}

		# Generate & send delete query

		public static function delete($table, $condition = null) {

			$query = new DB\Query\Delete($table, $condition);

			# ------------------------

			return self::send($query->query());
		}

		# Return last query holder

		public static function last() {

			return self::$last;
		}

		# Encode search value

		public static function encodeSearchValue($value, $add_slashes = true) {

			$value = strval($value); $add_slashes = Validate::boolean($add_slashes);

			$value_encoded = str_replace(' ', '%', str_replace(array('%', '_'), array('\%', '\_'), $value));

			# ------------------------

			return ($add_slashes ? addslashes($value_encoded) : $value_encoded);
		}

		# Get process log

		public static function log() {

			$log = array();

			foreach (self::$log as $result) {

				$status = $result->status; $query = $result->query; $time = number_format($result->time, 10);

				$summary = ($status ? ($result->rows . ' row(s)') : ('(' . $result->errno . ') ' . $result->error));

				$log[] = array('status' => $status, 'query' => $query, 'time' => $time, 'summary' => $summary);
			}

			return $log;
		}

		# Get process time

		public static function time() {

			return number_format(self::$time, 10);
		}
	}
}
