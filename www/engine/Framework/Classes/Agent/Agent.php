<?php

namespace {

	abstract class Agent {

		private static $robots = false, $mobiles = false;

		# Process agents array

		private static function processArray(&$array) {

			if (!is_array($array) || !($agent = getenv('HTTP_USER_AGENT'))) return false;

			foreach ($array as $item) if (false !== stripos($agent, $item)) return true;

			# ------------------------

			return false;
		}

		# Autoloader

		public static function __autoload() {

			self::$robots = Explorer::php(DIR_DATA . 'Agent/Robots.php');

			self::$mobiles = Explorer::php(DIR_DATA . 'Agent/Mobiles.php');
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
