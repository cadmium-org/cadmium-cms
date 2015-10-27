<?php

namespace {

	abstract class Mime extends Lister {

		protected static $list = [];

		# Autoloader

		public static function __autoload() {

			self::init('Mime.php');
		}
	}
}
