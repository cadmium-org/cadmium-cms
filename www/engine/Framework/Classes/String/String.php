<?php

namespace {

	abstract class String {

		# Validate string

		public static function validate($string) {

			return (('' !== ($string = strval($string))) ? $string : false);
		}

		# Format input string

		public static function input($string, $multiline = false, $maxlength = 0) {

			$string = self::validate($string); $multiline = Validate::boolean($multiline); $maxlength = Number::unsigned($maxlength);

			foreach (($string = explode("\n", $string)) as $key => $line) {

				$string[$key] = self::singleSpaces(trim(preg_replace('/[\t\n\r\0\x0B]+/', '', $line)));
			}

			if (!$multiline) $string = implode(' ', $string); else {

				$pattern = array("/^(\r\n)+/", "/(\r\n)+$/", "/(\r\n){2,}/"); $replacement = array("", "", "\r\n\r\n");

				$string = preg_replace($pattern, $replacement, implode("\r\n", $string));
			}

			return self::cut($string, $maxlength);
		}

		# Format output string

		public static function output($string, $maxlength = 0) {

			$string = self::validate($string); $maxlength = Number::unsigned($maxlength);

			$string = str_replace("\r\n", "&#13;&#10;", htmlspecialchars(self::cut($string, $maxlength)));

			# ------------------------

			return (('' !== $string) ? $string : false);
		}

		# Convert string to no spaces

		public static function stripSpaces($string) {

			$string = self::validate($string);

			$string = preg_replace('/ */', '', $string);

			# ------------------------

			return (('' !== $string) ? $string : false);
		}

		# Convert string to single spaces

		public static function singleSpaces($string) {

			$string = self::validate($string);

			$string = preg_replace('/  +/', ' ', $string);

			# ------------------------

			return (('' !== $string) ? $string : false);
		}

		# Cut string

		public static function cut($string, $maxlength, $ellipsis = false) {

			$string = self::validate($string); $maxlength = Number::unsigned($maxlength); $ellipsis = Validate::boolean($ellipsis);

			$length = (function_exists('mb_strlen') ? mb_strlen($string) : strlen($string));

			if ((0 === $maxlength) || ($length <= $maxlength)) return $string;

			$string = (function_exists('mb_substr') ? mb_substr($string, 0, $maxlength) : substr($string, 0, $maxlength));

			$string = (trim($string) . ($ellipsis ? '...' : ''));

			# ------------------------

			return (('' !== $string) ? $string : false);
		}

		# Get random string

		public static function random($length, $pool = STRING_POOL_DEFAULT) {

			$length = Number::unsigned($length); $pool = self::validate($pool); $pool_length = strlen($pool);

			$string = ''; for ($i = 0; $i < $length; $i++) $string .= substr($pool, mt_rand(0, ($pool_length - 1)), 1);

			# ------------------------

			return (('' !== $string) ? $string : false);
		}

		# Encode string

		public static function encode($key, $string) {

			$key = self::validate($key); $string = self::validate($string);

			return sha1($key . substr(sha1($string), 8, 32));
		}

		# Translit string

		public static function translit($string, $maxlength) {

			$string = self::validate($string); $maxlength = Number::unsigned($maxlength);

			$pattern = array (

				'А' => 'A',     'Б' => 'B',     'В' => 'V',     'Г' => 'G',
				'Д' => 'D',     'Е' => 'E',     'Ж' => 'ZH',    'З' => 'Z',
				'И' => 'I',     'Й' => 'J',     'К' => 'K',     'Л' => 'L',
				'М' => 'M',     'Н' => 'N',     'О' => 'O',     'П' => 'P',
				'Р' => 'R',     'С' => 'S',     'Т' => 'T',     'У' => 'U',
				'Ф' => 'F',     'Х' => 'H',     'Ц' => 'C',     'Ч' => 'CH',
				'Ш' => 'SH',    'Щ' => 'SCH',   'Ъ' => '',      'Ь' => '',
				'Ы' => 'Y',     'Э' => 'E',     'Ю' => 'JU',    'Я' => 'JA',
				'І' => 'I',     'Ї' => 'JI',    'Ё' => 'JO',

				'а' => 'a',     'б' => 'b',     'в' => 'v',     'г' => 'g',
				'д' => 'd',     'е' => 'e',     'ж' => 'zh',    'з' => 'z',
				'и' => 'i',     'й' => 'j',     'к' => 'k',     'л' => 'l',
				'м' => 'm',     'н' => 'n',     'о' => 'o',     'п' => 'p',
				'р' => 'r',     'с' => 's',     'т' => 't',     'у' => 'u',
				'ф' => 'f',     'х' => 'h',     'ц' => 'c',     'ч' => 'ch',
				'ш' => 'sh',    'щ' => 'sch',   'ъ' => '',      'ь' => '',
				'ы' => 'y',     'э' => 'e',     'ю' => 'ju',    'я' => 'ja',
				'і' => 'i',     'ї' => 'ji',    'ё' => 'jo'
			);

			$string = preg_replace('/[^a-zA-Z0-9\-]/', '-', strtr($string, $pattern));

			$string = preg_replace(array('/^[\-]+/', '/[\-]+$/', '/[\-]{2,}/'), array('', '', '-'), $string);

			# ------------------------

			return self::cut($string, $maxlength);
		}
	}
}
