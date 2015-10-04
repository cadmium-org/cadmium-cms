<?php

namespace DB\Utils {

	abstract class Query {

		protected $query = '';

		# Get field/table name

		protected function getName($name) {

			$name = strval($name);

			return trim(preg_replace('/[^a-zA-Z0-9_]/', '_', $name));
		}

		# Get field value

		protected function getValue($value) {

			$value = strval($value);

			return ("'" . addslashes($value) . "'");
		}

		# Get field sort

		protected function getSort($sort) {

			$sort = strval($sort);

			return ((strtoupper($sort) === 'DESC') ? 'DESC' : 'ASC');
		}

		# Convert data array to string

		protected function getString($source, $key_parser, $value_parser, $concat, $separator) {

			if (!is_array($source)) return strval($source);

			$parsers = ['name' => 'getName', 'value' => 'getValue', 'sort' => 'getSort']; $output = [];

			foreach ($source as $key => $value) {

				$key = ((null !== $key_parser) ? call_user_func([$this, $parsers[$key_parser]], $key) : '');

				$value = ((null !== $value_parser) ? call_user_func([$this, $parsers[$value_parser]], $value) : '');

				$output[] = trim($key . $concat . $value);
			}

			return implode($separator, $output);
		}

		# Return query

		public function query() {

			return $this->query;
		}
	}
}
