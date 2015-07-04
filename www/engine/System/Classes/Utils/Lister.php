<?php

namespace System\Utils {

	use Language, Number, String, Validate;

	abstract class Lister {

		private static $access = array (

			ACCESS_PUBLIC				=> 'ACCESS_PUBLIC',
			ACCESS_REGISTERED			=> 'ACCESS_REGISTERED',
			ACCESS_ADMINISTRATOR		=> 'ACCESS_ADMINISTRATOR'
		);

		private static $frequency = array (

			FREQUENCY_ALWAYS			=> 'FREQUENCY_ALWAYS',
			FREQUENCY_HOURLY			=> 'FREQUENCY_HOURLY',
			FREQUENCY_DAILY				=> 'FREQUENCY_DAILY',
			FREQUENCY_WEEKLY			=> 'FREQUENCY_WEEKLY',
			FREQUENCY_MONTHLY			=> 'FREQUENCY_MONTHLY',
			FREQUENCY_YEARLY			=> 'FREQUENCY_YEARLY',
			FREQUENCY_NEVER				=> 'FREQUENCY_NEVER'
		);

		private static $rank = array (

			RANK_GUEST					=> 'RANK_GUEST',
			RANK_USER					=> 'RANK_USER',
			RANK_ADMINISTRATOR			=> 'RANK_ADMINISTRATOR'
		);

		private static $sex = array (

			SEX_NOT_SELECTED			=> 'SEX_NOT_SELECTED',
			SEX_MALE					=> 'SEX_MALE',
			SEX_FEMALE					=> 'SEX_FEMALE'
		);

		private static $status = array (

			STATUS_ONLINE				=> 'STATUS_ONLINE',
			STATUS_MAINTENANCE			=> 'STATUS_MAINTENANCE',
			STATUS_UPDATE				=> 'STATUS_UPDATE'
		);

		private static $target = array (

			TARGET_SELF					=> 'TARGET_SELF',
			TARGET_BLANK				=> 'TARGET_BLANK'
		);

		# Get list

		private static function getList($list) {

			foreach ($list as $key => $value) $list[$key] = Language::get($value);

			return $list;
		}

		# Get value

		private static function getValue(&$list, $value = null, $validate = false) {

			$validate = Validate::boolean($validate);

			if ($validate) return (isset($list[$value]) ? $value : false);

			# ------------------------

			return (isset($list[$value]) ? Language::get($list[$value]) : false);
		}

		# Process access list

		public static function access($value = null, $validate = false) {

			if (null === $value) return self::getList(self::$access);

			$value = Number::unsigned($value);

			return self::getValue(self::$access, $value, $validate);
		}

		# Process frequency list

		public static function frequency($value = null, $validate = false) {

			if (null === $value) return self::getList(self::$frequency);

			$value = String::validate($value);

			return self::getValue(self::$frequency, $value, $validate);
		}

		# Process rank list

		public static function rank($value = null, $validate = false) {

			if (null === $value) return self::getList(self::$rank);

			$value = Number::unsigned($value);

			return self::getValue(self::$rank, $value, $validate);
		}

		# Process sex list

		public static function sex($value = null, $validate = false) {

			if (null === $value) return self::getList(self::$sex);

			$value = Number::unsigned($value);

			return self::getValue(self::$sex, $value, $validate);
		}

		# Process status list

		public static function status($value = null, $validate = false) {

			if (null === $value) return self::getList(self::$status);

			$value = Number::unsigned($value);

			return self::getValue(self::$status, $value, $validate);
		}

		# Process target list

		public static function target($value = null, $validate = false) {

			if (null === $value) return self::getList(self::$target);

			$value = Number::unsigned($value);

			return self::getValue(self::$target, $value, $validate);
		}
	}
}

?>
