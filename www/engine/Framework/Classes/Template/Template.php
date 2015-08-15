<?php

namespace {

	abstract class Template {

		private static $main = null, $status = STATUS_CODE_200;

		private static $language = '', $title = '', $description = '', $keywords = '', $robots = '', $meta = array(), $link = '';

		# Check if object is settable

		public static function settable($object) {

			return ($object instanceof Template\Utils\Settable);
		}

		# Create block

		public static function block($contents = '', $parse = true) {

			return new Template\Utils\Block($contents, $parse);
		}

		# Create group

		public static function group() {

			return new Template\Utils\Group();
		}

		# Set main block

		public static function main(Template\Utils\Block $block = null) {

			if (null === $block) return self::$main;

			self::$main = $block;
		}

		# Set status

		public static function status($status = null) {

			if (null === $status) return self::$status;

			if (Headers::isStatusCode($status)) self::$status = $status;

			# ------------------------

			return true;
		}

		# Get/set language

		public static function language($language = null) {

			if (null === $language) return self::$language;

			$language = strtolower(strval($language));

			if (preg_match(REGEX_TEMPLATE_LANGUAGE, $language)) self::$language = $language;

			# ------------------------

			return true;
		}

		# Get/set title

		public static function title($title = null) {

			if (null === $title) return self::$title;

			self::$title = strval($title);

			# ------------------------

			return true;
		}

		# Get/set meta description

		public static function description($description = null) {

			if (null === $description) return self::$description;

			self::$description = strval($description);

			# ------------------------

			return true;
		}

		# Get/set meta keywords

		public static function keywords($keywords = null) {

			if (null === $keywords) return self::$keywords;

			self::$keywords = strval($keywords);

			# ------------------------

			return true;
		}

		# Get/set meta robots

		public static function robots($index = null, $follow = null) {

			if ((null === $index) && (null === $follow)) return self::$robots;

			$index = boolval($index); $follow = boolval($follow);

			self::$robots = (($index ? 'INDEX' : 'NOINDEX') . ',' . ($follow ? 'FOLLOW' : 'NOFOLLOW'));

			# ------------------------

			return true;
		}

		# Get/set meta property

		public static function meta($name, $content = null) {

			if ('' === ($name = strval($name))) return false;

			if (null === $content) return (isset(self::$meta[$name]) ? self::$meta[$name] : false);

			self::$meta[$name] = strval($content);

			# ------------------------

			return true;
		}

		# Get/set canonical link

		public static function canonical($host = null, $link = null) {

			if ((null === $host) && (null === $link)) return self::$link;

			$host = strval($host); $link = strval($link);

			$url = new Url($link);

			self::$link = ($host . $url->get());

			# ------------------------

			return true;
		}

		# Output contents

		public static function output($status = null, $format = false) {

			if (null === self::$main) return false;

			if ((null === $status) || !Headers::isStatusCode($status)) $status = self::$status;

			self::$main->set('language',        self::$language);

			self::$main->set('head_title',      (('' !== self::$title) ? self::$title : 'UNTITLED'));

			self::$main->set('description',     self::$description);
			self::$main->set('keywords',        self::$keywords);
			self::$main->set('robots',          self::$robots);

			self::$main->loop('meta',           Arr::index(self::$meta, 'name', 'content'));

			if ('' === self::$link) self::$main->block('canonical')->disable();

			else self::$main->block('canonical')->link = self::$link;

			Headers::nocache(); Headers::status($status); Headers::content(MIME_TYPE_HTML);

			# ------------------------

			echo self::$main->contents($format);
		}
	}
}
