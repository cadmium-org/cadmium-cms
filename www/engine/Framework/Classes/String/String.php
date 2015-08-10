<?php

namespace {

	abstract class String {

		# Format input string

		public static function input($string, $multiline = false, $maxlength = 0) {

			$string = strval($string); $multiline = boolval($multiline); $maxlength = intabs($maxlength);

			foreach (($string = explode("\n", $string)) as $key => $line) {

				$string[$key] = self::singleSpaces(trim(preg_replace('/[\t\n\r\0\x0B]+/', '', $line)));
			}

			if (!$multiline) $string = implode(' ', $string); else {

				$pattern = array("/^(\r\n)+/", "/(\r\n)+$/", "/(\r\n){2,}/"); $replacement = array("", "", "\r\n\r\n");

				$string = preg_replace($pattern, $replacement, implode("\r\n", $string));
			}

			$string = self::cut($string, $maxlength);

			# ------------------------

			return $string;
		}

		# Format output string

		public static function output($string, $maxlength = 0) {

			$string = strval($string); $maxlength = intabs($maxlength);

			$string = str_replace("\r\n", "&#13;&#10;", htmlspecialchars(self::cut($string, $maxlength)));

			# ------------------------

			return $string;
		}

		# Convert string to no spaces

		public static function stripSpaces($string) {

			$string = strval($string);

			return preg_replace('/ */', '', $string);
		}

		# Convert string to single spaces

		public static function singleSpaces($string) {

			$string = strval($string);

			return preg_replace('/  +/', ' ', $string);
		}

		# Check if string length is between given values

		public static function between($string, $min, $max) {

			$string = strval($string); $min = intabs($min); $max = intabs($max);

			if ($min > $max) return false;

			return (preg_match(('/^(?=.{' . $min . ',' . $max . '}$).+$/'), $string) ? true : false);
		}

		# Cut string

		public static function cut($string, $maxlength, $ellipsis = false) {

			$string = strval($string); $maxlength = intabs($maxlength); $ellipsis = boolval($ellipsis);

			$length = (function_exists('mb_strlen') ? mb_strlen($string) : strlen($string));

			if ((0 === $maxlength) || ($length <= $maxlength)) return $string;

			$string = (function_exists('mb_substr') ? mb_substr($string, 0, $maxlength) : substr($string, 0, $maxlength));

			$string = (trim($string) . ($ellipsis ? '...' : ''));

			# ------------------------

			return $string;
		}

		# Get random string

		public static function random($length, $pool = STRING_POOL_DEFAULT) {

			$length = intabs($length); $pool = strval($pool); $pool_length = strlen($pool);

			$string = ''; for ($i = 0; $i < $length; $i++) $string .= substr($pool, mt_rand(0, ($pool_length - 1)), 1);

			# ------------------------

			return $string;
		}

		# Encode string

		public static function encode($key, $string) {

			$key = strval($key); $string = strval($string);

			return sha1($key . substr(sha1($string), 8, 32));
		}

		# Translit string

		public static function translit($string, $maxlength) {

			$string = strval($string); $maxlength = intabs($maxlength);

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

			$string = self::cut($string, $maxlength);

			# ------------------------

			return $string;
		}
	}
}
