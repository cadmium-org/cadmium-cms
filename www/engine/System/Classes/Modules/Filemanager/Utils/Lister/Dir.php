<?php

/**
 * @package Cadmium\System\Modules\Filemanager
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Filemanager\Utils\Lister {

	use Modules\Filemanager, Utils\View, Template;

	abstract class Dir {

		/**
		 * Get a directory item block
		 */

		public static function getBlock(Filemanager\Utils\Entity $entity, bool $ajax) : Template\Block {

			$view = View::get(!$ajax ? 'Blocks/Filemanager/Lister/Item/Dir' : 'Blocks/Filemanager/Ajax/Item/Dir');

			$parent = $entity->getParent(); $permissions = $parent->getPermissions();

			$name = $entity->getName(); $path = $entity->getPath();

			$query = ('?parent=' . $parent->getPath() .  '&name=' . $name);

			$link = (INSTALL_PATH . '/admin/content/filemanager/' . $parent->getOrigin() . '/dir' . $query);

			# Set data

			$view->name = $name; $view->path = $path;

			# Set link

			$view->link = (INSTALL_PATH . '/admin/content/filemanager/' . $parent->getOrigin() .	'?parent=' . $path);

			# Set buttons

			if (!$ajax) {

				$view->getBlock('edit')->link = $link;

				$view->getBlock('remove')->class = ($permissions['manage'] ? 'negative' : 'disabled');
			}

			# ------------------------

			return $view;
		}
	}
}
