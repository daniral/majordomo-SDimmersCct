<?php
/*
Уменьшить яркость на (array("value"=>1--100)). Без  параметров на 10.
*/

$inc;
$level = $this->getProperty('level');

if (isset($params['value']) && is_numeric($params['value'])) {
  $inc = $params['value'];
  if ($inc < 1) $inc *= -1;
  if ($inc > 100) $inc = 100;
  $inc *= -1;
}else {
  $inc = -10;
}

$level += $inc;

if ($level < 0) {
  $level = 0;
}

$this->callMethod('setLevel', array('value' => $level));
