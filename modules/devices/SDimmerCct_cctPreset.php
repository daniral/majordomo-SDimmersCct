<?php

/*
Изменить температуру.(array('value'=>'C'-cold,'N'-neutral,'W'-warmest))
*/

$cctSet;
$pset;

if (isset($params[value])) {
  $pset = $params[value];
  if ($pset == 'C' || $pset == 'c') {
    $cctSet = 0;
  } else if ($pset == 'N' || $pset == 'n') {
    $cctSet = 50;
  } else if ($pset == 'W' || $pset == 'w') {
    $cctSet = 100;
  } else {
    return;
  }
  if ($this->getProperty('cctLevel') == $cctSet) {
    return;
  }
  $this->callMethod('setCctLevel', array('value' => $cctSet));
}