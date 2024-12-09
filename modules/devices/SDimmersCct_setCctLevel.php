<?php

/*
Флаг 1 - автовыключение не запустится.
Установить температуру.(array("value"=>0 <--> 100 %))
Без  параметров то что в cctSeved.
Если cctSeved пуст то 0 (холодный).
*/

$new_cct;
$c_seved = $this->getProperty('cctSeved');

$this->setProperty('flag', '1');

if (isset($params['value']) && $params['value'] >= 0 && $params['value'] <= 100) {
	$new_cct = $params['value'];
} else if ($c_seved) {
	$new_cct = $c_seved;
} else {
	$new_cct = 0;
}

$this->setProperty('cctLevel', $new_cct);
