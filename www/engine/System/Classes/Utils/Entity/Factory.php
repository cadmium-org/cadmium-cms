<?php

namespace System\Utils\Entity {

    use Number, String;

    abstract class Factory {

        private static $cache = array();

        # Create new entity

        public static function create($type, $id = false) {

            if (false === ($type = String::validate($type))) return false;

            $id = Number::unsigned($id);

            $class_name = ('System\\Utils\\Entity\\Type\\' . $type . '\\Implementor');

            if (!class_exists($class_name)) return false;

            if ((0 !== $id) && isset(self::$cache[$type][$id])) return self::$cache[$type][$id];

            $entity = new $class_name; $entity->init($id);

            # ------------------------

            return $entity;
        }

        # Cache entity

        public static function cache($type, $entity) {

            if (false === ($type = String::validate($type))) return false;

            if (!($entity instanceof Entity)) return false;

            $class_name = ('System\\Utils\\Entity\\Type\\' . $type . '\\Implementor');

            if (!class_exists($class_name) || !($entity instanceof $class_name)) return false;

            if (false !== $entity->id) self::$cache[$type][$entity->id] = $entity;

            # ------------------------

            return true;
        }

        # Create new page entity

        public static function page($id = false) {

            return self::create('Page', $id);
		}

        # Create new menuitem entity

		public static function menuitem($id = false) {

            return self::create('Menuitem', $id);
		}

        # Create new user entity

		public static function user($id = false) {

            return self::create('User', $id);
		}
    }
}

?>
