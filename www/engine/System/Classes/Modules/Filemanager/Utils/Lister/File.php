<?php

/**
 * @package Cadmium\System\Modules\Filemanager
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Filemanager\Utils\Lister {

	use Modules\Filemanager, Utils\View, Number, Template;

	abstract class File {

		/**
		 * Get a file item block
		 */

		public static function getBlock(Filemanager\Utils\Entity $entity, bool $ajax) : Template\Block {

			$view = View::get(!$ajax ? 'Blocks/Filemanager/Lister/Item/File' : 'Blocks/Filemanager/Ajax/Item/File');

			$parent = $entity->getParent(); $permissions = $parent->getPermissions();

			$name = $entity->getName(); $path = $entity->getPath();

			$mime = Filemanager\Utils\Mime::get($entity->getExtension());

			$format = Filemanager\Utils\Mime::getFormat($entity->getExtension());

			$query = ('?parent=' . $parent->getPath() .  '&name=' . $name);

			$link = (INSTALL_PATH . '/admin/content/filemanager/' . $parent->getOrigin() . '/file' . $query);

			# Set data

			$view->name = $name; $view->path = $path; $view->mime = $mime; $view->format = $format;

			# Set link

			$view->link = ($permissions['browse'] ? (INSTALL_PATH . '/uploads/' . $path) : $link);

			$view->target = ($permissions['browse'] ? '_blank' : '_self');

			# Set info

			$view->size = Number::size($entity->getSize());

			# Set buttons

			if (!$ajax) {

				$view->getBlock('edit')->link = $link;

				$view->getBlock('remove')->class = ($permissions['manage'] ? 'negative' : 'disabled');

			} else {

				$is_media = (in_array($format, ['image', 'audio', 'video'], true));

				$view->getBlock('media')->class = ($is_media ? 'grey' : 'disabled');
			}

			# ------------------------

			return $view;
		}
	}
}
