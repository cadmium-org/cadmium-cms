<?php

/**
 * @package Cadmium\Framework\DB
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace {

	abstract class DB {

		private static $link = null, $last = null, $log = [], $time = 0;

		/**
		 * Connect to a database
		 */

		public static function connect(string $server, string $user, string $password, string $name) {

			# Establish connection

			// Ignore error to avoid warning when trying to connect to unavailable host

			if (false === ($link = @mysqli_connect($server, $user, $password))) throw new Exception\DBConnect;

			# Set encoding

			if (!mysqli_query($link, "SET character_set_client = 'utf8'")) throw new Exception\DBCharset;

			if (!mysqli_query($link, "SET character_set_results = 'utf8'")) throw new Exception\DBCharset;

			if (!mysqli_query($link, "SET collation_connection = 'utf8_general_ci'")) throw new Exception\DBCharset;

			# ------------------------

			self::$link = $link; self::name($name);
		}

		/**
		 * Select a database
		 */

		public static function name(string $name) {

			if (!mysqli_select_db(self::$link, $name)) throw new Exception\DBSelect;
		}

		/**
		 * Send a query
		 *
		 * @return DB\Result|false : the result object or false on failure
		 */

		public static function send(string $query) {

			if (null === self::$link) return (self::$last = false);

			$time = microtime(true); $result = mysqli_query(self::$link, $query); $time = (microtime(true) - $time);

			self::$last = new DB\Result(self::$link, $result, $query, $time);

			self::$log[] = self::$last; self::$time += $time;

			# ------------------------

			return self::$last;
		}

		/**
		 * Send a select query
		 *
		 * @param $table        a table name
		 * @param $selection    a string or an array where each value is a field name
		 * @param $condition    a string or an array where each key is a field name and each value is a field value
		 * @param $order        a string or an array where each key is a field name and each value is a sorting direction (ASC or DESC)
		 * @param $limit        a maximum number of rows to be selected
		 *
		 * @return DB\Result|false : the result object or false on failure
		 */

		public static function select(string $table, $selection, $condition = null, $order = null, int $limit = 0) {

			return self::send(new DB\Query\Select(...func_get_args()));
		}

		/**
		 * Send an insert query
		 *
		 * @param $table        a table name
		 * @param $set          an array where each key is a field name and each value is a field value, or an array of such arrays
		 * @param $multiple     tells that the set must be interpreted as a multi-dimensional array (for multi-row inserts)
		 * @param $ignore       tells to ignore insert errors, such as a duplicate-key error
		 *
		 * @return DB\Result|false : the result object or false on failure
		 */

		public static function insert(string $table, array $set, bool $multiple = false, bool $ignore = false) {

			return self::send(new DB\Query\Insert(...func_get_args()));
		}

		/**
		 * Send an update query
		 *
		 * @param $table        a table name
		 * @param $set          an array where each key is a field name and each value is a field value
		 * @param $condition    a string or an array where each key is a field name and each value is a field value
		 *
		 * @return DB\Result|false : the result object or false on failure
		 */

		public static function update(string $table, array $set, $condition = null) {

			return self::send(new DB\Query\Update(...func_get_args()));
		}

		/**
		 * Send a delete query
		 *
		 * @param $table        a table name
		 * @param $condition    a string or an array where each key is a field name and each value is a field value
		 *
		 * @return DB\Result|false : the result object or false on failure
		 */

		public static function delete(string $table, $condition = null) {

			return self::send(new DB\Query\Delete(...func_get_args()));
		}

		/**
		 * Count the number of rows in a table
		 *
		 * @param $table        a table name
		 * @param $column       a column name to count the number of values or '*' to count the number of rows in the table
		 * @param $distinct     tells to count the number of distinct values of the specified column
		 * @param $condition    a string or an array where each key is a field name and each value is a field value
		 *
		 * @return int|false : the number of rows or false on failure
		 */

		public static function count(string $table, string $column = '*', bool $distinct = false, $condition = null) {

			$result = self::send(new DB\Query\Count(...func_get_args()));

			return (($result && ($result->rows === 1)) ? intval($result->getRow()['count']) : false);
		}

		/**
		 * Get the MySQL version
		 *
		 * @return string|false : the version or false on failure
		 */

		public static function getVersion() {

			$result = self::send("SELECT VERSION() as version");

			return (($result && ($result->rows === 1)) ? strval($result->getRow()['version']) : false);
		}

		/**
		 * Get the last result object
		 *
		 * @return DB\Result|false|null : the result object, false if the last query failed, or null if there have been no queries sent
		 */

		public static function getLast() {

			return self::$last;
		}

		/**
		 * Get the array of all the result objects
		 */

		public static function getLog() : array {

			return self::$log;
		}

		/**
		 * Get the total time of all the queries sent
		 */

		public static function getTime() : string {

			return number_format(self::$time, 10);
		}
	}
}
