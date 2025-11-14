<?php

/**
 * Устанавливает яркость света лампы.
 *
 * Принимает массив параметров с ключом 'value', где указана яркость.
 *
 * @param array{
 *     value: int|null   // Яркость лампы в процентах (0–100)
 * } $params Ассоциативный массив параметров.
 *
 * @return void
 */

if (!isset($params['value'])) return;

$this->setProperty('level', $params['value'] ?? null, 'setLevelCct');