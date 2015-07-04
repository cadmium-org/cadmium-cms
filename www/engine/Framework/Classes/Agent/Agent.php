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

			if (is_array(self::$robots) && isset($_SERVER['HTTP_USER_AGENT'])) {

				foreach (self::$robots as $robot) if (false !== stripos($_SERVER['HTTP_USER_AGENT'], $robot)) return true;
			}

			return false;
		}

		# Check if user agent is mobile

		public static function isMobile() {

			if (is_array(self::$mobiles) && isset($_SERVER['HTTP_USER_AGENT'])) {

				foreach (self::$mobiles as $mobile) if (false !== stripos($_SERVER['HTTP_USER_AGENT'], $mobile)) return true;
			}

			return false;
		}
	}
}

?>
