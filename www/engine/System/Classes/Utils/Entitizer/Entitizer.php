<?php

namespace System\Utils {

    use Error;

    abstract class Entitizer {

        const ERROR_TYPE        = 'Invalid entity type';
        const ERROR_MANAGER     = 'Manager does not exists';

        private static $cache = array();

        # Registered types

        private static $types = array (

            ENTITY_TYPE_PAGE                => 'System\Utils\Entitizer\Type\Page\Implementor',
            ENTITY_TYPE_MENUITEM            => 'System\Utils\Entitizer\Type\Menuitem\Implementor',
            ENTITY_TYPE_USER                => 'System\Utils\Entitizer\Type\User\Implementor',
            ENTITY_TYPE_USER_SECRET         => 'System\Utils\Entitizer\Type\User\Secret\Implementor',
            ENTITY_TYPE_USER_SESSION        => 'System\Utils\Entitizer\Type\User\Session\Implementor'
        );

        private static $managers = array (

            ENTITY_TYPE_PAGE                => 'System\Utils\Entitizer\Type\Page\Manager',
            ENTITY_TYPE_MENUITEM            => 'System\Utils\Entitizer\Type\Menuitem\Manager',
            ENTITY_TYPE_USER                => 'System\Utils\Entitizer\Type\User\Manager'
        );

        # Check if type exists

        public static function exists($type) {

            $type = strval($type);

            return (isset(self::$types[$type]) && class_exists(self::$types[$type]));
        }

        # Create new entity

        public static function create($type, $id = 0) {

            $type = strval($type); $id = intabs($id);

            if (!isset(self::$types[$type]) || !class_exists(self::$types[$type])) {

                throw new Error\General(self::ERROR_TYPE);
            }

            if ((0 !== $id) && isset(self::$cache[$type][$id])) return self::$cache[$type][$id];

            $entity = new self::$types[$type]; $entity->initById($id);

            # ------------------------

            return $entity;
        }

        # Create new entity manager

        public static function manager($type, $id = 0) {

            $type = strval($type); $id = intabs($id);

            if (!isset(self::$managers[$type]) && !class_exists(self::$managers[$type])) {

                throw new Error\General(self::ERROR_MANAGER);
            }

            return new self::$managers[$type]($id);
        }

        # Cache entity

        public static function cache(Entitizer\Entity $entity) {

            $class = get_class($entity);

            if (false === ($type = array_search($class, self::$types, true))) return false;

            if (0 !== $entity->id) self::$cache[$type][$entity->id] = $entity;

            # ------------------------

            return true;
        }

        # Create new page entity

        public static function page($id = 0) {

            return self::create(ENTITY_TYPE_PAGE, $id);
		}

        # Create new menuitem entity

		public static function menuitem($id = 0) {

            return self::create(ENTITY_TYPE_MENUITEM, $id);
		}

        # Create new user entity

		public static function user($id = 0) {

            return self::create(ENTITY_TYPE_USER, $id);
		}

        # Create new user secret entity

		public static function userSecret($id = 0) {

            return self::create(ENTITY_TYPE_USER_SECRET, $id);
		}

        # Create new user session entity

		public static function userSession($id = 0) {

            return self::create(ENTITY_TYPE_USER_SESSION, $id);
		}
    }
}
