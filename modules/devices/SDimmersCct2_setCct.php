<?php

/*
Флаг 1 - авто режим и автовыключение не запустится.
Установить температуру.(array("value"=>0 <--> 100 %))
Вместо процентов можно вызвать пресеты:'coolest','cool','warm','warmest'.
*/

if (!isset($params['value'])) return;

$value = strtolower(trim($params['value']));
$cctOld = $this->getProperty('cctSaved') ?? 0;

$presets = [
    'coolest' => 0,
    'cool'    => 33,
    'warm'    => 66,
    'warmest' => 100,
];

if (isset($presets[$value])) {
    $cct = $presets[$value];
} elseif (is_numeric($value)) {
    // ограничиваем диапазон 0–100
    $cct = max(0, min(100, (int)$value));
} else {
    $cct = $cctOld;
}

$this->setProperty('cct', $cct);
