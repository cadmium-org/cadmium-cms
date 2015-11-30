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

		protected function getString($source = null, string $pattern = '', string $separator = '') {

			if (!is_array($source)) return strval($source);

			$regexs = ['key' => '/\^([a-z]+)/', 'value' => '/\$([a-z]+)/']; $matches = ['key' => [], 'value' => []];

			$parsers = ['name' => 'getName', 'value' => 'getValue', 'sort' => 'getSort']; $output = [];

			# Parse pattern

			foreach ($regexs as $name => $regex) preg_match($regex, $pattern, $matches[$name]);

			# Process replacements

			$replace = function(string $key, string $value) use($matches, $parsers, $pattern) {

				foreach ($matches as $name => $match) if (isset($parsers[$match[1]])) {

					$pattern = str_replace($match[0], [$this, $parsers[$match[1]]]($$name), $pattern);
				}

				return $pattern;
			};

			foreach ($source as $key => $value) $output[] = $replace($key, $value);

			# ------------------------

			return implode($separator, $output);
		}

		# Return query

		public function query() {

			return $this->query;
		}
	}
}
