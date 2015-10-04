<?php

namespace {

	abstract class Agent {

		private static $robots = [], $mobiles = [];

		# Process agents array

		private static function processArray(array &$array) {

			if (!($agent = getenv('HTTP_USER_AGENT'))) return false;

			foreach ($array as $item) if (false !== stripos($agent, $item)) return true;

			# ------------------------

			return false;
		}

		# Autoloader

		public static function __autoload() {

			$file_robots = (DIR_DATA . 'Agent/Robots.php');

			$file_mobiles = (DIR_DATA . 'Agent/Mobiles.php');

			if (is_array($robots = Explorer::php($file_robots))) self::$robots = $robots;

			if (is_array($mobiles = Explorer::php($file_mobiles))) self::$mobiles = $mobiles;
		}

		# Check if user agent is robot

		public static function isRobot() {

			return self::processArray(self::$robots);
		}

		# Check if user agent is mobile

		public static function isMobile() {

			return self::processArray(self::$mobiles);
		}
	}
}
