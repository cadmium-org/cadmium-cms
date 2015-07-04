<?php

namespace {

	abstract class DB {

		private static $link = false, $last = false, $log = array(), $time = 0;

		# Connect to database

		public static function connect($server, $user, $password, $name) {

			$server = String::validate($server); $user = String::validate($user);

			$password = String::validate($password); $name = String::validate($name);

			if (!($link = @mysqli_connect($server, $user, $password))) throw new Error\DBConnect();

			if (!@mysqli_select_db($link, $name)) throw new Error\DBSelect();

			if (!@mysqli_query($link, "SET character_set_client = 'utf8'")) throw new Error\DBCharset();

			if (!@mysqli_query($link, "SET character_set_results = 'utf8'")) throw new Error\DBCharset();

			if (!@mysqli_query($link, "SET collation_connection = 'utf8_general_ci'")) throw new Error\DBCharset();

			# ------------------------

			self::$link = $link;
		}

		# Send new query

		public static function send($query) {

			$query = String::validate($query);

			$time = microtime(true); $result = mysqli_query(self::$link, $query); $time = (microtime(true) - $time);

			if (is_object($result)) $holder = new DB\Result\Select($query, $result, $time);

			else if (true === $result) $holder = new DB\Result\Affect(self::$link, $query, $time);

			else if (false === $result) $holder = new DB\Result\Error(self::$link, $query, $time);

			self::$last = $holder; self::$log[] = $holder; self::$time += $holder->time;

			# ------------------------

			return $holder;
		}

		# Generate & send select query

		public static function select($table, $selection, $condition = false, $order = false, $limit = false, $group = false) {

			$query = new DB\Query\Select($table, $selection, $condition, $order, $limit, $group);

			return self::send($query->query());
		}

		# Generate & send insert query

		public static function insert($table, $dataset, $multiple = false) {

			$query = new DB\Query\Insert($table, $dataset, $multiple);

			return self::send($query->query());
		}

		# Generate & send update query

		public static function update($table, $dataset, $condition = false) {

			$query = new DB\Query\Update($table, $dataset, $condition);

			return self::send($query->query());
		}

		# Generate & send delete query

		public static function delete($table, $condition = false) {

			$query = new DB\Query\Delete($table, $condition);

			return self::send($query->query());
		}

		# Return last query holder

		public static function last() {

			return self::$last;
		}

		# Encode search value

		public static function encodeSearchValue($value, $add_slashes = true) {

			$value = String::validate($value); $add_slashes = Validate::boolean($add_slashes);

			$value_encoded = str_replace(' ', '%', str_replace(array('%', '_'), array('\%', '\_'), $value));

			# ------------------------

			return ($add_slashes ? addslashes($value_encoded) : $value_encoded);
		}

		# Get process log

		public static function log() {

			$log = array();

			foreach (self::$log as $result) {

				$id = $result->id; $query = $result->query; $time = number_format($result->time, 10);

				$status = ($result->status ? 'ok' : 'error');

				$summary = ($result->status ? ($result->rows . ' row(s)') : ('(' . $result->errno . ') ' . $result->error));

				$log[] = array('id' => $id, 'query' => $query, 'time' => $time, 'status' => $status, 'summary' => $summary);
			}

			return $log;
		}

		# Get process time

		public static function time() {

			return number_format(self::$time, 10);
		}
	}
}

?>
