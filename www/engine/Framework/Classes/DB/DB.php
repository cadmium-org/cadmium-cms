<?php

namespace {

	abstract class DB {

		private static $link = null, $last = null, $log = [], $time = 0;

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

		# Send query

		public static function send(string $query) {

			if (null === self::$link) return (self::$last = false);

			$time = microtime(true); $result = mysqli_query(self::$link, $query); $time = (microtime(true) - $time);

			self::$last = new DB\Utils\Result(self::$link, $result, $query, $time);

			self::$log[] = self::$last; self::$time += $time;

			# ------------------------

			return self::$last;
		}

		# Send select query

		public static function select(string $table, $selection, $condition = null, $order = null, int $limit = 0) {

			$query = new DB\Query\Select(...func_get_args());

			return self::send($query->query());
		}

		# Send insert query

		public static function insert(string $table, array $dataset, bool $multiple = false, bool $ignore = false) {

			$query = new DB\Query\Insert(...func_get_args());

			return self::send($query->query());
		}

		# Send update query

		public static function update(string $table, array $dataset, $condition = null) {

			$query = new DB\Query\Update(...func_get_args());

			return self::send($query->query());
		}

		# Send delete query

		public static function delete(string $table, $condition = null) {

			$query = new DB\Query\Delete(...func_get_args());

			return self::send($query->query());
		}

		# Return last query holder

		public static function last() {

			return self::$last;
		}

		# Return process log

		public static function log() {

			return self::$log;
		}

		# Return process time

		public static function time() {

			return number_format(self::$time, 10);
		}
	}
}
