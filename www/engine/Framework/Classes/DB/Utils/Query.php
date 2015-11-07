<?php

namespace DB\Utils {

	abstract class Query {

		protected $query = '';

		# Get field/table name

		protected function getName(string $name) {

			return preg_replace('/[^a-zA-Z0-9_]/', '_', trim($name));
		}

		# Get field value

		protected function getValue(string $value) {

			return ("'" . addslashes($value) . "'");
		}

		# Get field sort

		protected function getSort(string $sort) {

			return ((strtoupper($sort) !== 'DESC') ? 'ASC' : 'DESC');
		}

		# Convert data array to string

		protected function getString($source = null, string $key_parser = null, string $value_parser = null,

			string $concat = '', string $separator = '') {

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
