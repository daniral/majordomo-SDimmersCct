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
//


// --- Дефолтные свойства
$this->callMethod('byDefault');

// --- Обработка рабочих свойств
$source   = strtok($params['SOURCE'], ' ');
$property = $params['PROPERTY'];
$maxWork = ($property=='levelWork') ? $this->getProperty('levelMaxWork') : $this->getProperty('cctMaxWork');
$minWork = ($property=='levelWork') ? $this->getProperty('levelMinWork') : $this->getProperty('cctMinWork');
$workValue = normalizeRange($params['NEW_VALUE'], $minWork, $maxWork, 'number');
// Пересчитываем значение в проценты (0–100)
$value = (int)round(max(0, min(100, ($workValue - $minWork) / ($maxWork - $minWork) * 100)));

// Проверяем диапазон и источник
if ($minWork == $maxWork || $source === 'propertysUpdated' || $workValue === null || $value == $this->getProperty(str_replace('Work', '', $property))) return;

// Устанавливаем вычисленное значение
$this->setProperty(str_replace('Work', '', $property), $value, 'worksUpdated');

// При изменении CCT и выключенном статусе восстанавливаем уровень яркости
if ($property == 'cctWork' && !$this->getProperty('status')){
	$this->setProperty('level', $this->getProperty('levelSaved') ?? 100);
}
