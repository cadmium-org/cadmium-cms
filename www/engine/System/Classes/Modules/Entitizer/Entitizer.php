<?php

namespace System\Modules {

    use Error;

    abstract class Entitizer {

        const ERROR_TYPE            = 'Invalid entity type';
        const ERROR_DEFINITION      = 'Entity definition does not exists';
        const ERROR_CONTROLLER      = 'Entity controller does not exists';

        private static $cache = array();

        # Registred types

        private static $types = array (

            ENTITY_TYPE_PAGE                => 'System\Modules\Entitizer\Entity\Page',
            ENTITY_TYPE_MENUITEM            => 'System\Modules\Entitizer\Entity\Menuitem',
            ENTITY_TYPE_USER                => 'System\Modules\Entitizer\Entity\User',
            ENTITY_TYPE_USER_SECRET         => 'System\Modules\Entitizer\Entity\User\Secret',
            ENTITY_TYPE_USER_SESSION        => 'System\Modules\Entitizer\Entity\User\Session'
        );

        # Definitions

        private static $definitions = array (

            ENTITY_TYPE_PAGE                => 'System\Modules\Entitizer\Definition\Page',
            ENTITY_TYPE_MENUITEM            => 'System\Modules\Entitizer\Definition\Menuitem',
            ENTITY_TYPE_USER                => 'System\Modules\Entitizer\Definition\User',
            ENTITY_TYPE_USER_SECRET         => 'System\Modules\Entitizer\Definition\User\Secret',
            ENTITY_TYPE_USER_SESSION        => 'System\Modules\Entitizer\Definition\User\Session'
        );

        # Controlles

        private static $controllers = array (

            ENTITY_TYPE_PAGE                => 'System\Modules\Entitizer\Controller\Page',
            ENTITY_TYPE_MENUITEM            => 'System\Modules\Entitizer\Controller\Menuitem',
            ENTITY_TYPE_USER                => 'System\Modules\Entitizer\Controller\User'
        );

        # Create new entity

        public static function create($type, $id = 0) {

            $type = strval($type); $id = intabs($id);

            if (!isset(self::$types[$type]) || !class_exists(self::$types[$type])) {

                throw new Error\General(self::ERROR_TYPE);
            }

            if ((0 !== $id) && isset(self::$cache[$type][$id])) return self::$cache[$type][$id];

            $entity = new self::$types[$type]; $entity->init($id);

            # ------------------------

            return $entity;
        }

        # Create new entity definition

        public static function definition($type) {

            $type = strval($type);

            if (!isset(self::$definitions[$type]) || !class_exists(self::$definitions[$type])) {

                throw new Error\General(self::ERROR_DEFINITION);
            }

            return new self::$definitions[$type];
        }

        # Create new entity controller

        public static function controller($type, $id = 0) {

            $type = strval($type); $id = intabs($id);

            if (!isset(self::$controllers[$type]) || !class_exists(self::$controllers[$type])) {

                throw new Error\General(self::ERROR_CONTROLLER);
            }

            return new self::$controllers[$type]($id);
        }

        # Cache entity

        public static function cache(Entitizer\Utils\Entity $entity) {

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
