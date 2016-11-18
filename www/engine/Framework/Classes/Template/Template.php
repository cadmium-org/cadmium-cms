<?php

/**
 * @package Framework\Template
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2016, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace {

	abstract class Template {

		private static $globals = [], $widgets = [];

		/**
		 * Set a global variable
		 */

		public static function setGlobal(string $name, string $value) {

			self::$globals[$name] = $value;
		}

		/**
		 * Set a widget
		 */

		public static function setWidget(string $name, Template\Block $block) {

			self::$widgets[$name] = $block;
		}

		/**
		 * Get a global variable
		 *
		 * @return the variable or false if the variable is not set
		 */

		public static function getGlobal(string $name) {

			return (self::$globals[$name] ?? false);
		}

		/**
		 * Get a widget
		 *
		 * @return the widget or false if the widget is not set
		 */

		public static function getWidget(string $name) {

			return (self::$widgets[$name] ?? false);
		}

		/**
		 * Get the list of global variables
		 */

		public static function getGlobals() : array {

			return self::$globals;
		}

		/**
		 * Get the list of widgets
		 */

		public static function getWidgets() : array {

			return self::$widgets;
		}

		/**
		 * Create a new block object
		 */

		public static function createBlock(string $contents = '') : Template\Block {

			return new Template\Block($contents);
		}

		/*
		 * Check if a given variable is a block object
		 */

		public static function isBlock($object) : bool {

			return ($object instanceof Template\Block);
		}

		/**
		 * Output data contained in a given block object. The method also sends a custom HTTP status code
		 */

		public static function output(Template\Block $block, int $status = STATUS_CODE_200) {

			if (!Headers::isStatusCode($status)) $status = STATUS_CODE_200;

			Headers::sendNoCache(); Headers::sendStatus($status); Headers::sendContent(MIME_TYPE_HTML);

			# ------------------------

			echo $block->getContents();
		}
	}
}
