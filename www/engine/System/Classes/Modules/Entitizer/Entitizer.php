<?php

namespace System\Modules {

	use Exception;

	abstract class Entitizer {

		const ERROR_MESSAGE = 'Invalid entity type';

		# Objects cache

		private static $cache = [];

		# Entities classes

		private static $classes = [

			ENTITY_TYPE_PAGE                => 'System\Modules\Entitizer\Entity\Page',
			ENTITY_TYPE_MENUITEM            => 'System\Modules\Entitizer\Entity\Menuitem',
			ENTITY_TYPE_USER                => 'System\Modules\Entitizer\Entity\User',
			ENTITY_TYPE_USER_SECRET         => 'System\Modules\Entitizer\Entity\User\Secret',
			ENTITY_TYPE_USER_SESSION        => 'System\Modules\Entitizer\Entity\User\Session'
		];

		# Get entity

		public static function get(string $type, $id = null) {

			if (!isset(self::$classes[$type])) throw new Exception\General(self::ERROR_MESSAGE);

			$cached = (isset(self::$cache[$type][$id]) && (0 !== self::$cache[$type][$id]->id));

			# ------------------------

			return (!$cached ? new self::$classes[$type]($id) : self::$cache[$type][$id]);
		}

		# Cache entity

		public static function cache(Entitizer\Utils\Entity $entity) {

			$class = get_class($entity);

			if (false === ($type = array_search($class, self::$classes, true))) return false;

			if (0 !== $entity->id) self::$cache[$type][$entity->id] = $entity;

			# ------------------------

			return true;
		}

		# Create page entity

		public static function page($id = null) {

			return self::get(ENTITY_TYPE_PAGE, $id);
		}

		# Create menuitem entity

		public static function menuitem($id = null) {

			return self::get(ENTITY_TYPE_MENUITEM, $id);
		}

		# Create user entity

		public static function user($id = null) {

			return self::get(ENTITY_TYPE_USER, $id);
		}

		# Create user secret entity

		public static function userSecret($id = null) {

			return self::get(ENTITY_TYPE_USER_SECRET, $id);
		}

		# Create user session entity

		public static function userSession($id = null) {

			return self::get(ENTITY_TYPE_USER_SESSION, $id);
		}
	}
}
