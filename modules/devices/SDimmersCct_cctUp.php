<?php
/*
Увеличить температуру.(array("value"=>1--100)). Без  параметров 10.
*/

$cct = (int)$this->getProperty('cct');

// Определяем шаг увеличения и ограничиваем 1–100
$inc = isset($params['value']) && is_numeric($params['value']) 
    ? (int)$params['value'] 
    : 10;

// $inc всегда 1..100
$inc = max(1, min(100, abs($inc))); 

// Увеличиваем уровень, но не больше 100
$cct = min(100, $cct + $inc);

// Устанавливаем новое значение
$this->callMethod('setCct', ['value' => $cct]);