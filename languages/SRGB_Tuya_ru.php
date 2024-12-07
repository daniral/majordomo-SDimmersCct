<?php

$dictionary = array(

 'SRGB_Tuya_PATTERN_BRIGHTNESS' => 'ярк|ярч|яркость',
 'SRGB_Tuya_PATTERN_COLOR' => 'цвет'

);

foreach ($dictionary as $k => $v) {
 if (!defined('LANG_' . $k)) {
  @define('LANG_' . $k, $v);
 }
}
