<?php
/*
Уменьшить температуру.(array("value"=>1--100)). Без  параметров -10.
*/

$inc;
$cctLevel = $this->getProperty('cctLevel');

if (isset($params['value']) && is_numeric($params['value'])) {
  $inc = $params['value'];
  if ($inc < 1) $inc *= -1;
  if ($inc > 100) $inc = 100;
  $inc *= -1;
}else {
  $inc = -10;
}

$cctLevel += $inc;

if ($cctLevel < 0) {
  $cctLevel = 0;
}

$this->callMethod('setCct', array('value' => $cctLevel));