<?php
/*
Уменьшить температуру.(array("value"=>1--100)). Без  параметров 10.
*/

$cct = (int)$this->getProperty('cct');

// Определяем шаг уменьшения и ограничиваем 1–100
$inc = isset($params['value']) && is_numeric($params['value'])
    ? (int)$params['value']
    : 10;

// $inc всегда 1..100
$inc = max(1, min(100, abs($inc))); 

// Уменьшаем, но не ниже 0
$cct = max(0, $cct - $inc);

// Применяем новое значение
$this->callMethod('setCct', ['value' => $cct]);