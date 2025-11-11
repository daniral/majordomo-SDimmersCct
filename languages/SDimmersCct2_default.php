<?php

$dictionary = array(

    // Brightness control
    'SDimmersCct2_PATTERN_BRIGHTNESS' => 'bright|brightness|lighter|dimmer|light level|increase light|decrease light',

    // Color temperature control
    'SDimmersCct2_PATTERN_TEMPERATURE' => 'temperature|color|warm|cool|cold|neutral|tone|whit|yellow|blue'

);

foreach ($dictionary as $k => $v) {
    if (!defined('LANG_' . $k)) {
        @define('LANG_' . $k, $v);
    }
}
