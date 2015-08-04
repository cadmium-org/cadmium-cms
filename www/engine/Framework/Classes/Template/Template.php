<?php

namespace {

	abstract class Template {

		private static $init = false, $dir_name = '', $main = null, $blocks = array(), $status = STATUS_CODE_200;

		private static $language = '', $title = '', $description = '', $keywords = '', $robots = '', $meta = array(), $link = '';

		# Init template

		public static function init($dir_name) {

			if (self::$init) return;

			$dir_name = strval($dir_name);

			if (!Explorer::isDir($dir_name)) throw new Error\TemplateInit($dir_name);

			self::$init = true; self::$dir_name = $dir_name;
		}

		# Check if object is settable

		public static function settable($object) {

			return (($object instanceof Template\Utils\Block) || ($object instanceof Template\Utils\Group));
		}

		# Set main file

		public static function main($name = null) {

			if (!self::$init) return new Template\Utils\Block();

			if (null === $name) return (null !== self::$main) ? self::$main : new Template\Utils\Block();

			$name = strval($name);

			foreach (explode('/', $name) as $item) {

				if (!preg_match(REGEX_TEMPLATE_FILE_NAME, $item)) return new Template\Utils\Block();
			}

			$file_name = (self::$dir_name . '/Main/' . $name . '.tpl');

			if (false === ($contents = Explorer::contents($file_name))) return new Template\Utils\Block();

			return (self::$main = new Template\Utils\Block($contents));
		}

		# Create block

		public static function block($name = null) {

			if (!self::$init || (null === $name)) return new Template\Utils\Block();

			$name = strval($name);

			foreach (explode('/', $name) as $item) {

				if (!preg_match(REGEX_TEMPLATE_FILE_NAME, $item)) return new Template\Utils\Block();
			}

			if (isset(self::$blocks[$name])) return clone self::$blocks[$name];

			$file_name = (self::$dir_name . '/Blocks/' . $name . '.tpl');

			if (false === ($contents = Explorer::contents($file_name))) return new Template\Utils\Block();

			return (clone self::$blocks[$name] = new Template\Utils\Block($contents));
		}

		# Create group

		public static function group() {

			return new Template\Utils\Group();
		}

		# Set status

		public static function status($status = null) {

			if (!self::$init) return false;

			if (null === $status) return self::$status;

			if (Headers::isStatusCode($status)) self::$status = $status;

			# ------------------------

			return true;
		}

		# Get/set language

		public static function language($language = null) {

			if (!self::$init) return false;

			if (null === $language) return self::$language;

			$language = strtolower(strval($language));

			if (preg_match(REGEX_TEMPLATE_LANGUAGE, $language)) self::$language = $language;

			# ------------------------

			return true;
		}

		# Get/set title

		public static function title($title = null) {

			if (!self::$init) return false;

			if (null === $title) return self::$title;

			self::$title = strval($title);

			# ------------------------

			return true;
		}

		# Get/set meta description

		public static function description($description = null) {

			if (!self::$init) return false;

			if (null === $description) return self::$description;

			self::$description = strval($description);

			# ------------------------

			return true;
		}

		# Get/set meta keywords

		public static function keywords($keywords = null) {

			if (!self::$init) return false;

			if (null === $keywords) return self::$keywords;

			self::$keywords = strval($keywords);

			# ------------------------

			return true;
		}

		# Get/set meta robots

		public static function robots($index = null, $follow = null) {

			if (!self::$init) return false;

			if ((null === $index) && (null === $follow)) return self::$robots;

			$index = boolval($index); $follow = boolval($follow);

			self::$robots = (($index ? 'INDEX' : 'NOINDEX') . ',' . ($follow ? 'FOLLOW' : 'NOFOLLOW'));

			# ------------------------

			return true;
		}

		# Get/set meta property

		public static function meta($name, $content = null) {

			if (!self::$init) return false;

			if ('' === ($name = strval($name))) return false;

			if (null === $content) return (isset(self::$meta[$name]) ? self::$meta[$name] : false);

			self::$meta[$name] = strval($content);

			# ------------------------

			return true;
		}

		# Get/set canonical link

		public static function canonical($host = null, $link = null) {

			if (!self::$init) return false;

			if ((null === $host) && (null === $link)) return self::$link;

			$host = strval($host); $link = strval($link);

			$url = new Url($link);

			self::$link = ($host . $url->get());

			# ------------------------

			return true;
		}

		# Output contents

		public static function output($status = null, $format = false) {

			if (!self::$init || (null === self::$main)) return false;

			if ((null === $status) || !Headers::isStatusCode($status)) $status = self::$status;

			self::$main->language       = self::$language;

			self::$main->head_title     = (('' !== self::$title) ? self::$title : 'UNTITLED');

			self::$main->description    = self::$description;
			self::$main->keywords       = self::$keywords;
			self::$main->robots         = self::$robots;

			self::$main->loop('meta', Arr::index(self::$meta, 'name', 'content'));

			if ('' === self::$link) self::$main->block('canonical')->disable();

			else self::$main->block('canonical')->link = self::$link;

			Headers::nocache(); Headers::status($status); Headers::content(MIME_TYPE_HTML);

			# ------------------------

			echo self::$main->contents($format);
		}
	}
}
