<?php
/*
Увеличить яркость.(array('value'=>1--100)). Без  параметров +10.
*/

$level = $this->getProperty('level');
$inc;

if (isset($params['value']) && is_numeric($params['value'])) {
  $inc = $params['value'];
  if ($inc < 1) $inc *= -1;
  if ($inc > 100) $inc = 100;
}else {
  $inc = 10;
}

$level += $inc;
 
if ($level > 100) {
  $level = 100;
}

$this->callMethod('setLevel', array('value' => $level));
