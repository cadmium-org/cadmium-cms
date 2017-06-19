<?php

/**
 * @package Cadmium\Framework\DB
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace DB {

	use Type;

	abstract class Query {

		protected $query = '';

		/**
		 * Get a field/table name
		 */

		protected function getName(string $name) : string {

			return preg_replace('/[^a-zA-Z0-9_]/', '_', trim($name));
		}

		/**
		 * Get a field value
		 */

		protected function getValue(string $value) : string {

			return ('\'' . addslashes($value) . '\'');
		}

		/**
		 * Get a range of values
		 */

		protected function getRange(array $value) : string {

			$parser = function ($value) { if (is_scalar($value)) return $this->getValue($value); };

			return ('(' . implode(', ', array_filter(array_map($parser, $value))) . ')');
		}

		/**
		 * Get an operatable value (value with an operator)
		 */

		protected function getOperatable($value) {

			if (is_scalar($value)) return ('= ' . $this->getValue($value));

			if (is_array($value)) return ('IN ' . $this->getRange($value));

			if ($value instanceof Type\Not) return ('NOT ' . $this->getValue($value->get()));

			if ($value instanceof Type\Like) return ('LIKE ' . $this->getValue($value->get()));

			if ($value instanceof Type\LessThan) return ('< ' . $value->get());

			if ($value instanceof Type\GreaterThan) return ('> ' . $value->get());

			if ($value instanceof Type\LessThanOrEqual) return ('<= ' . $value->get());

			if ($value instanceof Type\GreaterThanOrEqual) return ('>= ' . $value->get());

			# ------------------------

			return '';
		}

		/**
		 * Get a field sorting direction
		 */

		protected function getDirection(string $direction) : string {

			return ((strtoupper($direction) !== 'DESC') ? 'ASC' : 'DESC');
		}

		/**
		 * Convert a data array to a string
		 */

		protected function getString($source = null, string $pattern = '', string $separator = '') : string {

			if (!is_array($source)) return (is_scalar($source) ? strval($source) : '');

			$regexs = ['key' => '/\^([a-z]+)/', 'value' => '/\$([a-z]+)/']; $matches = ['key' => [], 'value' => []];

			$parsers = ['name' => 'getName', 'value' => 'getValue', 'range' => 'getRange',

						'operatable' => 'getOperatable', 'direction' => 'getDirection'];

			$output = []; $count = 0;

			# Parse pattern

			foreach ($regexs as $name => $regex) preg_match($regex, $pattern, $matches[$name]);

			# Process replacements

			foreach ($source as $key => $value) {

				$output[$count] = $pattern; $item = &$output[$count++];

				foreach ($matches as $name => $match) if (isset($match[1]) && isset($parsers[$match[1]])) {

					try { $replace = [$this, $parsers[$match[1]]]($$name); } catch (\TypeError $e) { $replace = ''; }

					$item = str_replace($match[0], $replace, $item);
				}
			}

			# ------------------------

			return implode($separator, $output);
		}

		/**
		 * Convert the object to a string
		 */

		public function __toString() : string {

			return $this->query;
		}
	}
}
