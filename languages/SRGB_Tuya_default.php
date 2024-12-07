<?php

$dictionary = array(

 'SRGB_Tuya_PATTERN_BRIGHTNESS' => 'brightness',
 'SRGB_Tuya_PATTERN_COLOR' => 'color'

);

foreach ($dictionary as $k => $v) {
 if (!defined('LANG_' . $k)) {
  @define('LANG_' . $k, $v);
 }
}
d