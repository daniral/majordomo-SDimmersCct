<?php

/*

Уменьшить температуру.(array("value"=>1-50)). Без  параметров -10.
Уменьшает минимум до 1%

*/

$inc;
$cctLevel = $this->getProperty('cctLevel');

if (isset($params[value]) && $params[value] > 0 && $params[value] <= 50) {
  $inc = $params[value];
  if ($inc > 0) {
    $inc = $inc * -1;
  }
} else {
  $inc = '-10';
}

$cctLevel += $inc;

if ($cctLevel < 1) {
  $cctLevel = 1;
}

if ($cctLevel == $this->getProperty('cctLevel')) {
  return;
}

$this->callMethod('setCctLevel', array('value' => $cctLevel));