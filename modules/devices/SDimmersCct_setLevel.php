<?php

/*
Флаг 1 - авто режим и автовыключение не запустится.
Установить яркость света.(array("value"=> 0 <--> 100 %))
*/

$value = normalizeRange($params['value'] ?? null);
if ($value === null) return;

$this->setProperty('level', $value);
