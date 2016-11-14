<?php

namespace Utils {

	abstract class SEO {

		private static $data = [];

		# Init SEO data

		public static function init() {

			self::$data = [];
		}

		# Get/set title

		public static function title(string $value = null) {

			if (null === $value) return (self::$data['title'] ?? '');

			self::$data['title'] = $value;
		}

		# Get/set description

		public static function description(string $value = null) {

			if (null === $value) return (self::$data['description'] ?? '');

			self::$data['description'] = $value;
		}

		# Get/set keywords

		public static function keywords(string $value = null) {

			if (null === $value) return (self::$data['keywords'] ?? '');

			self::$data['keywords'] = $value;
		}

		# Get/set robots index

		public static function robotsIndex(bool $value = null) {

			if (null === $value) return (self::$data['robots_index'] ?? false);

			self::$data['robots_index'] = $value;
		}

		# Get/set robots follow

		public static function robotsFollow(bool $value = null) {

			if (null === $value) return (self::$data['robots_follow'] ?? false);

			self::$data['robots_follow'] = $value;
		}

		# Get/set canonical

		public static function canonical(string $value = null) {

			if (null === $value) return (self::$data['canonical'] ?? '');

			self::$data['canonical'] = $value;
		}
	}
}
