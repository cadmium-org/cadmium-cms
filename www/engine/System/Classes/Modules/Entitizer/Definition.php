<?php

namespace System\Modules\Entitizer {

	use Exception;

	abstract class Definition {

		const ERROR_MESSAGE = 'Entity definition does not exist';

		# Objects cache

		private static $cache = [];

		# Definitions classes

		private static $classes = [

			ENTITY_TYPE_PAGE                => 'System\Modules\Entitizer\Definition\Page',
			ENTITY_TYPE_MENUITEM            => 'System\Modules\Entitizer\Definition\Menuitem',
			ENTITY_TYPE_USER                => 'System\Modules\Entitizer\Definition\User',
			ENTITY_TYPE_USER_SECRET         => 'System\Modules\Entitizer\Definition\User\Secret',
			ENTITY_TYPE_USER_SESSION        => 'System\Modules\Entitizer\Definition\User\Session'
		];

		# Get definition

		public static function get(string $type) {

			if (!isset(self::$classes[$type])) throw new Exception\General(self::ERROR_MESSAGE);

			if (!isset(self::$cache[$type])) self::$cache[$type] = new self::$classes[$type];

			# ------------------------

			return self::$cache[$type];
		}
	}
}
