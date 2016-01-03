<?php

namespace {

	abstract class Str {

		# Format input string

		public static function input(string $string, int $maxlength = 0, bool $multiline = false, bool $codestyle = false) {

			foreach (($string = explode("\n", $string)) as $key => $line) {

				if ($multiline && $codestyle) $string[$key] = rtrim(preg_replace('/[\r\0\x0B]+/', '', $line));

				else $string[$key] = trim(preg_replace(['/[ \t]+/', '/[\r\0\x0B]+/'], [' ', ''], $line));
			}

			if (!$multiline) $string = preg_replace('/ {2,}/', ' ', trim(implode(' ', $string), ' '));

			else $string = preg_replace('/(\r\n){3,}/', "\r\n\r\n", trim(implode("\r\n", $string), "\r\n"));

			# ------------------------

			return self::cut($string, $maxlength);
		}

		# Format output string

		public static function output(string $string, int $maxlength = 0) {

			$search = ['$', '%', '{', '}']; $replace = ['&#36;', '&#37;', '&#123;', '&#125;'];

			return str_replace($search, $replace, htmlspecialchars(self::cut($string, $maxlength)));
		}

		# Convert string to no spaces

		public static function stripSpaces(string $string) {

			return preg_replace('/ +/', '', $string);
		}

		# Convert string to single spaces

		public static function singleSpaces(string $string) {

			return preg_replace('/ +/', ' ', $string);
		}

		# Translit string

		public static function translit(string $string) {

			$pattern = [

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
			];

			# ------------------------

			return strtr($string, $pattern);
		}

		# Convert string to url

		public static function toUrl(string $string, int $maxlength) {

			$string = self::toLower(self::translit($string));

			return self::cut(trim(preg_replace('/[^a-zA-Z0-9]+/', '-', $string), '-'), $maxlength);
		}

		# Convert string to variable name

		public static function toVar(string $string, int $maxlength) {

			$string = self::toLower(self::translit($string));

			return self::cut(trim(preg_replace('/[^a-zA-Z0-9]+/', '_', $string), '_'), $maxlength);
		}

		# Transform string to lower case

		public static function toLower(string $string) {

			return (function_exists('mb_strtolower') ? 'mb_strtolower' : 'strtolower')($string);
		}

		# Transform string to upper case

		public static function toUpper(string $string) {

			return (function_exists('mb_strtoupper') ? 'mb_strtoupper' : 'strtoupper')($string);
		}

		# Get string length

		public static function length(string $string) {

			return (function_exists('mb_strlen') ? 'mb_strlen' : 'strlen')($string);
		}

		# Get substring

		public static function substr(string $string, int $start, int $length) {

			return (function_exists('mb_substr') ? 'mb_substr' : 'substr')($string, $start, $length);
		}

		# Check if string length is between given values

		public static function between(string $string, int $min, int $max) {

			return ((($length = self::length($string)) >= $min) && ($length <= $max));
		}

		# Cut string

		public static function cut(string $string, int $maxlength, bool $ellipsis = false) {

			if (($maxlength < 1) || (self::length($string = trim($string)) <= $maxlength)) return $string;

			$string = (rtrim(self::substr($string, 0, $maxlength)) . ($ellipsis ? '...' : ''));

			# ------------------------

			return $string;
		}

		# Get random string

		public static function random(int $length, string $pool = STR_POOL_DEFAULT) {

			if (($length < 1) || (0 === ($pool_length = self::length($pool)))) return '';

			$string = ''; for ($i = 0; $i < $length; $i++) $string .= self::substr($pool, random_int(0, ($pool_length - 1)), 1);

			# ------------------------

			return $string;
		}

		# Encode string

		public static function encode(string $key, string $string) {

			return sha1($key . substr(sha1($string), 8, 32));
		}
	}
}
