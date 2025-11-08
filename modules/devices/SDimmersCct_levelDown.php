<?php
/*
Уменьшить яркость на (array("value"=>1--100)). Без  параметров на 10.
*/

$level = (int)$this->getProperty('level');

// Определяем шаг увеличения и ограничиваем 1–100
$inc = isset($params['value']) && is_numeric($params['value']) 
    ? (int)$params['value'] 
    : 10;

// $inc всегда 1..100
$inc = max(1, min(100, abs($inc))); 

// Увеличиваем уровень, но не больше 100
$level = max(0, $level - $inc);

// Устанавливаем новое значение
$this->callMethod('setLevel', ['value' => $level]);