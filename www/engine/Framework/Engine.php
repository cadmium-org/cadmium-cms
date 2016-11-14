<?php

namespace {

	abstract class Engine {

		/**
		 * Parse template contents
		 */

		private static function parseContents(string $contents, Throwable $exc) {

		   $contents = str_replace('$message$',            $exc->getMessage(),                  $contents);

		   $contents = str_replace('$file$',               $exc->getFile(),                     $contents);

		   $contents = str_replace('$line$',               $exc->getLine(),                     $contents);

		   $contents = str_replace('$trace$',              nl2br($exc->getTraceAsString()),     $contents);

		   # ------------------------

		   return $contents;
		}

		/**
		 * Get a client IP address
		 */

		public static function getIP() {

			if (!empty(getenv('HTTP_CLIENT_IP')))           return getenv('HTTP_CLIENT_IP');

			if (!empty(getenv('HTTP_X_FORWARDED_FOR')))     return getenv('HTTP_X_FORWARDED_FOR');

			if (!empty(getenv('HTTP_X_FORWARDED')))         return getenv('HTTP_X_FORWARDED');

			if (!empty(getenv('HTTP_FORWARDED_FOR')))       return getenv('HTTP_FORWARDED_FOR');

			if (!empty(getenv('HTTP_FORWARDED')))           return getenv('HTTP_FORWARDED');

			if (!empty(getenv('REMOTE_ADDR')))              return getenv('REMOTE_ADDR');

			# ------------------------

			return 'unknown';
		}

		/**
		 * Display an exception screen
		 */

		public static function handleException(Throwable $exc) {

			# Load template

			$file_name = (DIR_TEMPLATES . 'Exception.tpl');

			if (false === ($contents = @file_get_contents($file_name))) $output = nl2br($exc);

			else $output = self::parseContents($contents, $exc);

			# Set headers

			header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');

			header('Cache-Control: no-store, no-cache, must-revalidate');

			header('Cache-Control: post-check=0, pre-check=0', false);

			header('Pragma: no-cache');

			header(getenv('SERVER_PROTOCOL') . ' 500 Internal Server Error', true, 500);

			header('Content-type: text/html; charset=UTF-8');

			# ------------------------

			exit ($output);
		}
	}
}
