<?php
/**
 * Обработчик изменения рабочих свойств (levelWork, cctWork).
 *
 * Пересчитывает рабочее значение обратно в диапазон 1–100
 * и обновляет основное свойство (level или cct).
 *
 * @param array $params [
 *     'SOURCE'    => string, // источник изменения
 *     'PROPERTY'  => string, // изменённое свойство (levelWork/cctWork)
 *     'NEW_VALUE' => int,    // новое значение
 * ]
 */

if ($this->getProperty('level') === '') $this->setProperty('level', '50');
if ($this->getProperty('levelMinWork') === '') $this->setProperty('levelMinWork', '0');
if ($this->getProperty('levelMaxWork') === '') $this->setProperty('levelMaxWork', '254');
if ($this->getProperty('cct') === '') $this->setProperty('cct', '50');
if ($this->getProperty('cctMinWork') === '') $this->setProperty('cctMinWork', '153');
if ($this->getProperty('cctMaxWork') === '') $this->setProperty('cctMaxWork', '370');

$status    = $this->getProperty('status');
$source    = strtok($params['SOURCE'], ' ');
$property  = $params['PROPERTY'];
$maxWork   = ($property=='levelWork') ? $this->getProperty('levelMaxWork') : $this->getProperty('cctMaxWork');
$minWork   = ($property=='cctWork') ? $this->getProperty('levelMinWork') : $this->getProperty('cctMinWork');
$workValue = normalizeRange($params['NEW_VALUE'], $minWork, $maxWork, 'number');

if ($property === 'levelWork' && $workValue <= 0) {
	$this->callMethod('turnOff');
	return;
}

if ($minWork == $maxWork || $source == 'propertysUpdated' || $workValue === null) return;

$value = (int)round(max(0, min(100, ($workValue - $minWork) / ($maxWork - $minWork) * 100)));

// Обновляем основное свойство, если изменилось
$this->setProperty(str_replace('Work', '', $property), $value, 'worksUpdated');
$this->setProperty(str_replace('Work', '', $property).'Saved', $value);

if ($targetProperty == 'cctWork' && !$status){
	$this->setProperty('level', $this->getProperty('levelSaved') ?? 100, 'worksUpdated');
}

if(!$status && $value > 0) $this->setProperty('status', 1);





// $status    = $this->getProperty('status');
// $source    = strtok($params['SOURCE'] ?? '', ' ');
// $property  = $params['PROPERTY'] ?? '';
// $workValue = $params['NEW_VALUE'] ?? null;

// // Определяем диапазон и целевое свойство
// switch ($property) {
//     case 'levelWork':
//         $minWork = $this->getProperty('levelMinWork');
//         $maxWork = $this->getProperty('levelMaxWork');
//         $targetProperty = 'level';
//         break;

//     case 'cctWork':
//         $minWork = $this->getProperty('cctMinWork');
//         $maxWork = $this->getProperty('cctMaxWork');
//         $targetProperty = 'cct';
//         break;

//     default:
//         return;
// }

// // Проверяем диапазон и источник
// if ($minWork == $maxWork || $source == 'propertysUpdated') return;

// // Ограничиваем значение строго в рамках диапазона
// $workValue = normalizeRange($workValue, $minWork, $maxWork);
// if ($workValue === null) return;

// // Пересчитываем значение в проценты (1–100)
// $newValue = max(1, min(100, (int)round(($workValue - $minWork) / ($maxWork - $minWork) * 100)));

// // Обновляем основное свойство, если изменилось
// $this->setProperty($targetProperty, $newValue, 'worksUpdated');

// if ($targetProperty == 'cct' && !$status){
// 	$this->setProperty('level', $this->getProperty('levelSaved') ?? 100, 'worksUpdated');
// }