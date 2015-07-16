<?php

namespace {

	abstract class Agent {

		private static $robots = false, $mobiles = false;

		# Autoloader

		public static function __autoload() {

			self::$robots = Explorer::php(DIR_DATA . 'Agent/Robots.php');

			self::$mobiles = Explorer::php(DIR_DATA . 'Agent/Mobiles.php');
		}

		# Check if user agent is robot

		public static function isRobot() {

			if (!is_array(self::$robots) || !($agent = getenv('HTTP_USER_AGENT'))) return false;

			foreach (self::$robots as $robot) if (false !== stripos($agent, $robot)) return true;

			# ------------------------

			return false;
		}

		# Check if user agent is mobile

		public static function isMobile() {

			if (!is_array(self::$mobiles) || !($agent = getenv('HTTP_USER_AGENT'))) return false;

			foreach (self::$mobiles as $mobile) if (false !== stripos($agent, $mobile)) return true;

			# ------------------------

			return false;
		}
	}
}

?>
