<?php

namespace System\Modules\Entitizer {

	use Exception;

	abstract class Definition {

		private static $error_message = 'Entity definition does not exist';

		# Objects cache

		protected static $cache = [];

		# Definitions classes

		protected static $classes = [

			ENTITY_TYPE_PAGE                => 'System\Modules\Entitizer\Definition\Page',
			ENTITY_TYPE_MENUITEM            => 'System\Modules\Entitizer\Definition\Menuitem',
			ENTITY_TYPE_VARIABLE            => 'System\Modules\Entitizer\Definition\Variable',
			ENTITY_TYPE_WIDGET              => 'System\Modules\Entitizer\Definition\Widget',
			ENTITY_TYPE_USER                => 'System\Modules\Entitizer\Definition\User',
			ENTITY_TYPE_USER_SECRET         => 'System\Modules\Entitizer\Definition\User\Secret',
			ENTITY_TYPE_USER_SESSION        => 'System\Modules\Entitizer\Definition\User\Session'
		];

		# Get definition

		public static function get(string $type) {

			if (!isset(self::$classes[$type])) throw new Exception\General(self::$error_message);

			$cached = isset(self::$cache[$type]);

			# ------------------------

			return (!$cached ? (self::$cache[$type] = new self::$classes[$type]) : self::$cache[$type]);
		}
	}
}
