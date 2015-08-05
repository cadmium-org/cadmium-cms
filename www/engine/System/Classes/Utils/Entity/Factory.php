<?php

namespace System\Utils\Entity {

    abstract class Factory {

        private static $cache = array();

        # Create new entity

        public static function create($type, $id = 0) {

            if ('' === ($type = strval($type))) return false;

            $id = intabs($id);

            $class_name = ('System\\Utils\\Entity\\Type\\' . $type . '\\Implementor');

            if (!class_exists($class_name)) return false;

            if ((0 !== $id) && isset(self::$cache[$type][$id])) return self::$cache[$type][$id];

            $entity = new $class_name; $entity->initById($id);

            # ------------------------

            return $entity;
        }

        # Cache entity

        public static function cache($type, $entity) {

            if ('' === ($type = strval($type))) return false;

            if (!($entity instanceof Entity)) return false;

            $class_name = ('System\\Utils\\Entity\\Type\\' . $type . '\\Implementor');

            if (!class_exists($class_name) || !($entity instanceof $class_name)) return false;

            if (0 !== $entity->id) self::$cache[$type][$entity->id] = $entity;

            # ------------------------

            return true;
        }

        # Create new page entity

        public static function page($id = 0) {

            return self::create('Page', $id);
		}

        # Create new menuitem entity

		public static function menuitem($id = 0) {

            return self::create('Menuitem', $id);
		}

        # Create new user entity

		public static function user($id = 0) {

            return self::create('User', $id);
		}
    }
}
