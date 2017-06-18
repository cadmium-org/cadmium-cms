<?php

/**
 * @package Cadmium\System\Modules\Extend
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Modules\Extend\Utils {

	use Frames, Utils\View, Template;

	abstract class Handler extends Frames\Admin\Area\Panel {

		protected $loader = null;

		/**
		 * Get the contents block
		 */

		protected function getContents() : Template\Block {

			$contents = View::get(static::$view_main);

			# Set items

			foreach ($this->loader->getItems() as $name => $data) {

				$contents->getBlock('items')->addItem($item = View::get(static::$view_item));

				foreach ($data as $property => $value) $item->$property = $value;

				# Process item

				$this->processItem($item, $data);
			}

			# Process contents

			$this->processContents($contents);

			# ------------------------

			return $contents;
		}
	}
}
