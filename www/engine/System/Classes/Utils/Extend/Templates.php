<?php

namespace System\Utils\Extend {
	
	use System\Utils\Utils, Error, Explorer, Template, String;
	
	class Templates {
		
		const ERROR_DIRECTORY	= 'Templates directory does not exist';
		const ERROR_SELECT		= 'Templates not found';
		
		private static $loaded = false, $section = false, $items = array(), $active = false;
		
		# Get items
		
		private static function getItems($section) {
			
			$items = array(); $section = ((false !== $section) ? ($section . '/') : '');
			
			foreach (Explorer::listDirs(DIR_SYSTEM_TEMPLATES . $section) as $name) {
				
				$config_file = (DIR_SYSTEM_TEMPLATES . $section . $name . '/Config.php');
				
				$config_values = array('name', 'title', 'author');
				
				if (false === ($config = Utils::config($config_file, $config_values))) continue;
				
				if (!(self::valid($config['name']) && ($config['name'] === $name))) continue;
				
				$items[$config['name']] = $config;
			}
			
			ksort($items); return $items;
		}
		
		# Check if name valid
		
		public static function valid($name) {
			
			$name = String::validate($name);
			
			return (preg_match(REGEX_TEMPLATE_NAME, $name) ? true : false);
		}
		
		# Validate name
		
		public static function validate($name) {
			
			$name = String::validate($name);
			
			return (self::valid($name) ? $name : false);
		}
		
		# Check if template exists
		
		public static function exists($name) {
			
			if (array() === self::$items) return false;
			
			$name = String::validate($name);
			
			# ------------------------
			
			return (self::valid($name) && isset(self::$items[$name]));
		}
		
		# Load template
		
		public static function load($section, $name, $default) {
			
			if (false !== self::$loaded) return;
			
			$section = String::validate($section); $name = String::validate($name); $default = String::validate($default);
			
			if (!Explorer::isDir(DIR_SYSTEM_TEMPLATES . $section)) throw new Error\General(self::ERROR_DIRECTORY);
			
			self::$loaded = true; self::$section = $section; self::$items = self::getItems($section);
			
			$name_valid = (self::exists($name) || self::exists($name = $default));
			
			if (!($name_valid || (null !== ($name = key(self::$items))))) throw new Error\General(self::ERROR_SELECT);
			
			# ------------------------
			
			Template::init(DIR_SYSTEM_TEMPLATES . ((false !== self::$section) ? (self::$section . '/') : '') . (self::$active = $name));
		}
		
		# Return items
		
		public static function items($section) {
			
			return (((false === self::$section) || ($section === self::$section)) ? self::$items : self::getItems($section));
		}
		
		# Return active templates name
		
		public static function active() {
			
			return self::$active;
		}
		
		# Return active templates data
		
		public static function data($name) {
			
			if (false === self::$active) return false;
			
			if (null === $name) return self::$items[self::$active];
			
			$name = String::validate($name);
			
			return (isset(self::$items[self::$active][$name]) ? self::$items[self::$active][$name] : false);
		}
	}
}

?>