<?php
/**
 * Обработчик изменения рабочих свойств (levelWork, cctWork).
 *
 * Пересчитывает рабочее значение обратно в диапазон 0–100
 * и обновляет основное свойство (level или cct).
 *
 * @param array $params [
 *     'SOURCE'    => string, // источник изменения
 *     'PROPERTY'  => string, // изменённое свойство (levelWork/cctWork)
 *     'NEW_VALUE' => int,    // новое значение
 * ]
 */

// --- Дефолтные свойства
if ($this->getProperty('level') === '') $this->setProperty('level', '50');
if ($this->getProperty('levelMinWork') === '') $this->setProperty('levelMinWork', '0');
if ($this->getProperty('levelMaxWork') === '') $this->setProperty('levelMaxWork', '254');
if ($this->getProperty('cct') === '') $this->setProperty('cct', '50');
if ($this->getProperty('cctMinWork') === '') $this->setProperty('cctMinWork', '153');
if ($this->getProperty('cctMaxWork') === '') $this->setProperty('cctMaxWork', '370');


$source    = strtok($params['SOURCE'] ?? '', ' ');
$property  = $params['PROPERTY'] ?? '';
$maxWork   = $property === 'levelWork' ? $this->getProperty('levelMaxWork') : $this->getProperty('cctMaxWork');
$minWork   = $property === 'levelWork' ? $this->getProperty('levelMinWork') : $this->getProperty('cctMinWork');
$workValue = normalizeRange($params['NEW_VALUE'] ?? null, $minWork, $maxWork, 'number');
// Пересчитываем значение в проценты (0–100)
$newValue = max(0, min(100, (int)round(($workValue - $minWork) / ($maxWork - $minWork) * 100)));

// Проверяем диапазон, источник, данные
if ($minWork == $maxWork || $source == 'propertysUpdated' || $workValue === null || $newValue == $this->getProperty(str_replace('Work', '', $property))) return;

// Обновляем основное свойство и сохраняем
$this->setProperty(str_replace('Work', '', $property), $newValue, 'worksUpdated');
if($newValue > 0 || $property != 'levelWork') $this->setProperty(str_replace('Work', '', $property).'Saved', $newValue);

if ($property == 'cctWork' && !$this->getProperty('status')){
	$this->setProperty('level', $this->getProperty('levelSaved') ?? 100);
	
}
