<?php

namespace DB\Utils {

	use String;

	abstract class Query {

		protected $query;

		# Sanitize name

		private function sanitizeName($name) {

			return trim(preg_replace('/[^a-zA-Z0-9_]/', '_', $name));
		}

		# Get table name

		protected function getTableName($name) {

			$name = String::validate($name);

			return strtolower(self::sanitizeName($name));
		}

		# Get alias name

		protected function getAliasName($name) {

			$name = String::validate($name);

			return strtolower(self::sanitizeName($name));
		}

		# Get field name

		protected function getFieldName($name) {

			$name = String::validate($name);

			if (preg_match('/^([^\(]+)[ ]*\([ ]*(.+)[ ]*\)$/', trim($name), $matches)) {

				$function = strtoupper(self::sanitizeName($matches[1]));

				$param = (($matches[2] === '*') ? '*' : strtolower(self::sanitizeName($matches[2])));

				return ($function . '(' . $param . ')');
			}

			return strtolower(self::sanitizeName($name));
		}

		# Get field value

		protected function getFieldValue($value) {

			$value = String::validate($value);

			return ("'" . addslashes($value) . "'");
		}

		# Get field sort

		protected function getFieldSort($sort) {

			$sort = String::validate($sort);

			return ((strtoupper($sort) === 'DESC') ? 'DESC' : 'ASC');
		}

		# Get fieldset

		protected function getFieldset($source, $key_parser, $value_parser, $concat, $separator) {

			if (!is_array($source)) return String::validate($source);

			$key_parser = String::validate($key_parser); $value_parser = String::validate($value_parser);

			$concat = String::validate($concat); $separator = String::validate($separator);

			$parsers = array('name' => 'getFieldName', 'value' => 'getFieldValue', 'sort' => 'getFieldSort');

			if ((false !== $key_parser) && !isset($parsers[$key_parser])) return false;

			if ((false !== $value_parser) && !isset($parsers[$value_parser])) return false;

			$output = array();

			foreach ($source as $key => $value) {

				$key = ((false !== $key_parser) ? call_user_func(array($this, $parsers[$key_parser]), $key) : '');

				$value = ((false !== $value_parser) ? call_user_func(array($this, $parsers[$value_parser]), $value) : '');

				$output[] = trim($key . $concat . $value);
			}

			# ------------------------

			return implode($separator, $output);
		}

		# Return query

		public function query() {

			return $this->query;
		}
	}
}
