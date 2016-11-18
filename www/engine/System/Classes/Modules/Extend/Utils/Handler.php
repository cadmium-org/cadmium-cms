<?php

namespace Modules\Extend\Utils {

	use Frames, Utils\View;

	abstract class Handler extends Frames\Admin\Area\Authorized {

		protected $loader = null;

		# Get contents

		protected function getContents() {

			$contents = View::get(static::$view_main);

			# Set items

			foreach ($this->loader->items() as $name => $data) {

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
