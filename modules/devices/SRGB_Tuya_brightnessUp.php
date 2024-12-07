<?php
/*
Увеличить яркость.(array('value'=>1-50)). Без  параметров +10.
Увеличит максимум до 100%.
*/

$brightness = $this->getProperty('brightness');
$inc;

if (isset($params[value]) && $params[value] > 0 && $params[value] <= 50) {
  $inc = $params[value];
  if ($inc < 0) {
    $inc = $inc * -1;
  }
} else {
  $inc = '10';
}

$brightness += $inc;

if ($brightness > 100) {
  $brightness = 100;
}

if ($brightness == $this->getProperty('brightness')) {
  return;
}

$this->callMethod('turnOn', array('brightness' => $brightness));
