<?php

namespace {

	abstract class Debug {

		# Get script peak memory usage

		public static function memory() {

			return number_format(memory_get_peak_usage());
		}

		# Get script elapsed time

		public static function time() {

			return number_format((microtime(true) - REQUEST_TIME_FLOAT), 10);
		}
	}
}
