<?php

/**
 * @package Cadmium\Framework\Agent
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace {

	abstract class Agent {

		private static $mobiles = [], $robots = [];

		/**
		 * Search an agent in the list
		 *
		 * @return bool : true if the agent is present in the list, otherwise false
		 */

		private static function search(array &$list) : bool {

			if (empty($_SERVER['HTTP_USER_AGENT'])) return false;

			foreach ($list as $item) if (false !== stripos($_SERVER['HTTP_USER_AGENT'], $item)) return true;

			# ------------------------

			return false;
		}

		/**
		 * Autoloader
		 */

		public static function __autoload() {

			$file_mobiles = (DIR_DATA . 'Agent/Mobiles.php');

			$file_robots = (DIR_DATA . 'Agent/Robots.php');

			if (is_array($mobiles = Explorer::include($file_mobiles))) self::$mobiles = $mobiles;

			if (is_array($robots = Explorer::include($file_robots))) self::$robots = $robots;
		}

		/**
		 * Check if a current user agent is a mobile device
		 *
		 * @return bool : true if the agent is present in the mobile devices list, otherwise false
		 */

		public static function isMobile() : bool {

			return self::search(self::$mobiles);
		}

		/**
		 * Check if a current user agent is a robot
		 *
		 * @return bool : true if the agent is present in the robots list, otherwise false
		 */

		public static function isRobot() : bool {

			return self::search(self::$robots);
		}
	}
}
