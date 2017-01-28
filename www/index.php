<?php

/**
 * @package Cadmium
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

# Require engine main file

require_once './engine/Main.php';

# Create a router instance

(new Dispatcher)->route();
