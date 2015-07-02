<?php

namespace System\Utils {
	
	use Error, Arr, DB, Geo\Timezone, Number, String, Validate;
	
	abstract class Config {
		
		const ERROR_MESSAGE	= "Unable to load configuration";
		
		private static $config = array (
			
			CONFIG_PARAM_ADMIN_LANGUAGE			=> false,
			CONFIG_PARAM_ADMIN_TEMPLATE			=> false,
			CONFIG_PARAM_ADMIN_EMAIL			=> false,
			
			CONFIG_PARAM_SITE_LANGUAGE			=> false,
			CONFIG_PARAM_SITE_TEMPLATE			=> false,
			CONFIG_PARAM_SITE_TITLE				=> false,
			CONFIG_PARAM_SITE_STATUS			=> false,
			CONFIG_PARAM_SITE_DESCRIPTION		=> false,
			CONFIG_PARAM_SITE_KEYWORDS			=> false,
			
			CONFIG_PARAM_SYSTEM_TIMEZONE		=> false,
			CONFIG_PARAM_SYSTEM_URL				=> false,
			
			CONFIG_PARAM_USERS_REGISTRATION		=> false
		);
		
		# Init configuration
		
		public static function init() {
			
			DB::select(TABLE_CONFIG, array('name', 'value'), false, array('name' => 'ASC'));
			
			if (!(DB::last() && DB::last()->status)) throw new Error\General(self::ERROR_MESSAGE);
			
			while (null !== ($param = DB::last()->row())) self::set($param['name'], $param['value']);
			
			foreach (self::$config as $name => $value) define(('CONFIG_' . mb_strtoupper($name)), $value);
			
			# ------------------------
			
			return true;
		}
		
		# Save configuration
		
		public static function save() {
			
			$set = Arr::index(self::$config, 'name', 'value');
			
			if (!(DB::delete(TABLE_CONFIG) && DB::last()->status)) return false;
			
			if (!(DB::insert(TABLE_CONFIG, $set, true) && DB::last()->status)) return false;
			
			# ------------------------
			
			return true;
		}
		
		# Set value
		
		public static function set($name, $value) {
			
			$name = String::validate($name);
			
			# Set admin language
			
			if ($name === CONFIG_PARAM_ADMIN_LANGUAGE) {
				
				return (false !== (self::$config[$name] = Extend\Languages::validate($value)));
			}
			
			# Set admin template
			
			if ($name === CONFIG_PARAM_ADMIN_TEMPLATE) {
				
				return (false !== (self::$config[$name] = Extend\Templates::validate($value)));
			}
			
			# Set admin email
			
			if ($name === CONFIG_PARAM_ADMIN_EMAIL) {
				
				return (false !== (self::$config[$name] = Validate::email($value)));
			}
			
			# Set site language
			
			if ($name === CONFIG_PARAM_SITE_LANGUAGE) {
				
				return (false !== (self::$config[$name] = Extend\Languages::validate($value)));
			}
			
			# Set site template
			
			if ($name === CONFIG_PARAM_SITE_TEMPLATE) {
				
				return (false !== (self::$config[$name] = Extend\Templates::validate($value)));
			}
			
			# Set site title
			
			if ($name === CONFIG_PARAM_SITE_TITLE) {
				
				return (false !== (self::$config[$name] = String::validate($value)));
			}
			
			# Set site status
			
			if ($name === CONFIG_PARAM_SITE_STATUS) {
				
				return (false !== (self::$config[$name] = Number::unsigned($value)));
			}
			
			# Set site description
			
			if ($name === CONFIG_PARAM_SITE_DESCRIPTION) {
				
				return (null !== (self::$config[$name] = String::validate($value)));
			}
			
			# Set site keywords
			
			if ($name === CONFIG_PARAM_SITE_KEYWORDS) {
				
				return (null !== (self::$config[$name] = String::validate($value)));
			}
			
			# Set system timezone
			
			if ($name === CONFIG_PARAM_SYSTEM_TIMEZONE) {
				
				return (false !== (self::$config[$name] = Timezone::validate($value)));
			}
			
			# Set system url
			
			if ($name === CONFIG_PARAM_SYSTEM_URL) {
				
				return (false !== (self::$config[$name] = Validate::url($value)));
			}
			
			# Set users registration
			
			if ($name === CONFIG_PARAM_USERS_REGISTRATION) {
				
				return (null !== (self::$config[$name] = Validate::boolean($value)));
			}
			
			# ------------------------
			
			return false;
		}
		
		# Get value
		
		public static function get($name) {
			
			$name = String::validate($name);
			
			return (isset(self::$config[$name]) ? self::$config[$name] : false);
		}
	}
}

?>