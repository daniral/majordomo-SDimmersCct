<?php

/*
Флаг 1 - авто режим и автовыключение не запустится.
Установить температуру.(array("value"=>0 <--> 100 %))
Вместо процентов можно вызвать пресеты:'cool','neutral','warm'.
*/

if (!isset($params['value'])) return;
$this->setProperty('flag', 1);
$this->setProperty('cctLevel', strtolower($params['value']));
