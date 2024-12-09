<?php
/*
Увеличить яркость.(array('value'=>1-50)). Без  параметров +10.
Увеличит максимум до 100%.
*/

$level = $this->getProperty('level');
$inc;

if (isset($params[value]) && $params[value] > 0 && $params[value] <= 50) {
  $inc = $params[value];
  if ($inc < 0) {
    $inc = $inc * -1;
  }
} else {
  $inc = '10';
}

$level += $inc;

if ($level > 100) {
  $level = 100;
}

if ($level == $this->getProperty('level')) {
  return;
}

$this->callMethod('setLevel', array('value' => $level));
