<?php

/**
 * Устанавливает цветовую температуру лампы.
 *   
 * Принимает массив параметров с ключом 'value', где указана температура в процентах
 * или один из строковых пресетов:
 *   - 'coolest'
 *   - 'cool'
 *   - 'warm'
 *   - 'warmest'
 *
 *     callMethod('имя объекта.setCct', array("value"=>0--100));
 *     callMethod('имя объекта.setCct', array("value"=>'coolest'));
 * 
 * @param array{
 *     value: int|string|null   // Цветовая температура 0–100% или строковый пресет
 * } $params Ассоциативный массив параметров.
 *
 * @return void
 */
if (!isset($params['value'])) return;

$this->setProperty('cct', $params['value'] ?? null, 'setLevelCct');
