<?php

$dictionary = array(

 'SDimmerCct_PATTERN_BRIGHTNESS' => 'brightness',
 'SDimmerCct_PATTERN_TEMPERATURE' => 'temperature'

);

foreach ($dictionary as $k => $v) {
 if (!defined('LANG_' . $k)) {
  @define('LANG_' . $k, $v);
 }
}
