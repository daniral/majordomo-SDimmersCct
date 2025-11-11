<?php

$dictionary = array(

    // Распознавание команд, связанных с яркостью
    'SDimmersCct2_PATTERN_BRIGHTNESS' => 'ярк|ярч|яркость|светлее|приглуш|тусклее',

    // Распознавание команд, связанных с цветовой температурой
    'SDimmersCct2_PATTERN_TEMPERATURE' => 'температур|тепл|цвет|холодн|синее|желт|прохладн|нейтрал'

);

foreach ($dictionary as $k => $v) {
    if (!defined('LANG_' . $k)) {
        @define('LANG_' . $k, $v);
    }
}
