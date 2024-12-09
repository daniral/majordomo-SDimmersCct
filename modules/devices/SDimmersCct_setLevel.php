<?php

/*
Флаг 1 - автовыключение не запустится.
Установить яркость света.(array("value"=> 0 <--> 100 %))
Без  параметров то что в levelSaved.
Если levelSaved пусто то 100%.
*/

$b_seved = $this->getProperty('levelSaved');
$new_brightLevel;

$this->setProperty('flag', '1');

if (isset($params['value']) && $params['value'] >= 0 && $params['value'] <= 100) {
	$new_brightLevel = $params['value'];
	if ($new_brightLevel == 0) {
		$this->setProperty('flag', 0);
		$this->setProperty('illuminanceFlag', 0);
	}
} else if ($b_seved) {
	$new_brightLevel = $b_seved;
} else {
	$new_brightLevel = 100;
}

$this->setProperty('level', $new_brightLevel);
