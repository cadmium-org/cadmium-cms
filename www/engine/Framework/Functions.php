<?php

namespace {

    # Cast variable to unsigned integer

    function intabs($value) {

        return abs(intval($value));
    }

    # Cast variable to boolean

    if (!function_exists('boolval')) {

        function boolval($value) {

            return filter_var($value, FILTER_VALIDATE_BOOLEAN);
        }
    }
}
