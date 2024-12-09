<?php

$dictionary = array(

 'SDimmersCct_PATTERN_BRIGHTNESS' => 'ярк|ярч|яркость',
 'SDimmersCct_PATTERN_TEMPERATURE' => 'температур|температура|цвет|теплота'

);

foreach ($dictionary as $k => $v) {
 if (!defined('LANG_' . $k)) {
  @define('LANG_' . $k, $v);
 }
}
