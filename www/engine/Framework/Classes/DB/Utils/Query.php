<?php

namespace DB\Utils {

	use String;

	abstract class Query {

		protected $query;

		# Get field/table name

		protected function getName($name) {

			$name = String::validate($name);

			return trim(preg_replace('/[^a-zA-Z0-9_]/', '_', $name));
		}

		# Get field value

		protected function getValue($value) {

			$value = String::validate($value);

			return ("'" . addslashes($value) . "'");
		}

		# Get field sort

		protected function getSort($sort) {

			$sort = String::validate($sort);

			return ((strtoupper($sort) === 'DESC') ? 'DESC' : 'ASC');
		}

		# Convert data array to string

		protected function getString($source, $key_parser, $value_parser, $concat, $separator) {

			if (!is_array($source)) return String::validate($source);

			$parsers = array('name' => 'getName', 'value' => 'getValue', 'sort' => 'getSort');

			if ((false !== $key_parser) && !isset($parsers[$key_parser])) return '';

			if ((false !== $value_parser) && !isset($parsers[$value_parser])) return '';

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
