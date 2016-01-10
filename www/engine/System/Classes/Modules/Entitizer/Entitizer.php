<?php

namespace Modules {

	use Exception;

	abstract class Entitizer {

		private static $error_message = 'Invalid entity type';

		# Objects cache

		protected static $cache = [];

		# Entities classes

		protected static $classes = [

			ENTITY_TYPE_PAGE                => 'Modules\Entitizer\Entity\Page',
			ENTITY_TYPE_MENUITEM            => 'Modules\Entitizer\Entity\Menuitem',
			ENTITY_TYPE_VARIABLE            => 'Modules\Entitizer\Entity\Variable',
			ENTITY_TYPE_WIDGET              => 'Modules\Entitizer\Entity\Widget',
			ENTITY_TYPE_USER                => 'Modules\Entitizer\Entity\User',
			ENTITY_TYPE_USER_SECRET         => 'Modules\Entitizer\Entity\User\Secret',
			ENTITY_TYPE_USER_SESSION        => 'Modules\Entitizer\Entity\User\Session'
		];

		# Get entity

		public static function get(string $type, int $id = 0) {

			if (!isset(self::$classes[$type])) throw new Exception\General(self::$error_message);

			$cached = isset(self::$cache[$type][$id]);

			# ------------------------

			return (!$cached ? new self::$classes[$type]($id) : self::$cache[$type][$id]);
		}
	}
}
