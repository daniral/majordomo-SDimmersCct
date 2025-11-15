<?php
/**
 * ============================================================
 * Dictionary for SDimmersCct2 lamp control
 * ============================================================
 *
 * $dictionary - array defining patterns to recognize commands:
 *   - 'SDimmersCct2_PATTERN_BRIGHTNESS': keywords for brightness control
 *   - 'SDimmersCct2_PATTERN_TEMPERATURE': keywords for color temperature control
 *
 * Each value is a string with keywords separated by |
 * Constants with the LANG_ prefix are defined for each key
 *   e.g., LANG_SDimmersCct2_PATTERN_BRIGHTNESS
 * These constants are used to recognize text or voice commands.
 */
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
