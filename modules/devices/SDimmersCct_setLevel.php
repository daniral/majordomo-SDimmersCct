<?php

/*
Флаг 1 - авто режим и автовыключение не запустится.
Установить яркость света.(array("value"=> 0 <--> 100 %))
*/

if (!isset($params['value']) || !is_numeric($params['value'])) return;
$newValue=$params['value'];
if ($newValue < 0) $newValue=0;
if ($newValue > 100) $newValue=100;
$this->setProperty('flag', 1);
$this->setProperty('level', $newValue);
