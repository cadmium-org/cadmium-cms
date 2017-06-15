<?php

/**
 * @package Cadmium\System\Utils
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

namespace Utils {

	use Template;

	abstract class Popup extends Messages {

		protected static $view = 'Blocks/Utils/Popup';

		protected static $types = ['positive', 'negative'];

		protected static $items = [];
	}
}
