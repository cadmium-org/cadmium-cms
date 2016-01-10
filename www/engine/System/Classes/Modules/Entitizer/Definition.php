<?php

namespace Modules\Entitizer {

	use Exception;

	abstract class Definition {

		private static $error_message = 'Entity definition does not exist';

		# Objects cache

		protected static $cache = [];

		# Definitions classes

		protected static $classes = [

			ENTITY_TYPE_PAGE                => 'Modules\Entitizer\Definition\Page',
			ENTITY_TYPE_MENUITEM            => 'Modules\Entitizer\Definition\Menuitem',
			ENTITY_TYPE_VARIABLE            => 'Modules\Entitizer\Definition\Variable',
			ENTITY_TYPE_WIDGET              => 'Modules\Entitizer\Definition\Widget',
			ENTITY_TYPE_USER                => 'Modules\Entitizer\Definition\User',
			ENTITY_TYPE_USER_SECRET         => 'Modules\Entitizer\Definition\User\Secret',
			ENTITY_TYPE_USER_SESSION        => 'Modules\Entitizer\Definition\User\Session'
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
