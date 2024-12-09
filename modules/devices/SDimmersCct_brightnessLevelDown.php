<?php
/*
Уменьшить яркость на (array("value"=>1-50)). Без  параметров на 10.
уменьшает минимум до 1%.
*/

$inc;
$level = $this->getProperty('level');

if (isset($params[value]) && $params[value] > 0 && $params[value] <= 50) {
  $inc = $params[value];
  if ($inc > 0) {
    $inc = $inc * -1;
  }
} else {
  $inc = '-10';
}

$level += $inc;

if ($level < 1) {
  $level = 1;
}

if ($level == $this->getProperty('level')) {
  return;
}

$this->callMethod('setLevel', array('value' => $level));
