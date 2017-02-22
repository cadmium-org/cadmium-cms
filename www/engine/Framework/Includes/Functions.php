<?php

/**
 * @package Cadmium\Framework
 * @author Anton Romanov
 * @copyright Copyright (c) 2015-2017, Anton Romanov
 * @link http://cadmium-cms.com
 */

# Short type creators

function not_(string $value) {

	return new Type\Not($value);
}

function like_(string $value) {

	return new Type\Like($value);
}

function lt_(int $value) {

	return new Type\LessThan($value);
}

function gt_(int $value) {

	return new Type\GreaterThan($value);
}

function le_(int $value) {

	return new Type\LessThanOrEqual($value);
}

function ge_(int $value) {

	return new Type\GreaterThanOrEqual($value);
}
