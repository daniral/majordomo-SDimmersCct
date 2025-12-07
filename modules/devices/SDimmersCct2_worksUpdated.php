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

$source   = strtok($params['SOURCE'], ' ');
$property = $params['PROPERTY'];
$maxWork = ($property=='levelWork') ? $this->getProperty('levelMaxWork') : $this->getProperty('cctMaxWork');
$minWork = ($property=='levelWork') ? $this->getProperty('levelMinWork') : $this->getProperty('cctMinWork');
$workValue = normalizeRange($params['NEW_VALUE'], $minWork, $maxWork, 'number');

// Проверяем диапазон и источник
if ($minWork == $maxWork || $source === 'propertysUpdated' || $workValue === null) return;

if ($workValue <= 0 && $property === 'levelWork') {
	$this->callMethod('turnOff');
	return;
}

//$this->setProperty('flag', 1);

// Пересчитываем значение в проценты (0–100)
$value = (int)round(max(0, min(100, ($workValue - $minWork) / ($maxWork - $minWork) * 100)));

// Устанавливаем вычисленное значение
$this->setProperty(str_replace('Work', '', $property), $value, 'worksUpdated');
$this->setProperty(str_replace('Work', '', $property).'Saved', $value);

// При изменении CCT и выключенном статусе восстанавливаем уровень яркости
if ($property === 'cctWork' && !$this->getProperty('status')) {
    $this->setProperty('level', $this->getProperty('levelSaved') ?? 100, 'worksUpdated');
}

if(!$this->getProperty('status') && $value > 0)
	$this->setProperty('status', 1);





// $status   = $this->getProperty('status');
// $source   = strtok($params['SOURCE'] ?? '', ' ');
// $property = $params['PROPERTY'] ?? '';
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

// // Пересчитываем значение в проценты (0–100)
// $newValue = max(0, min(100, (int)round(($workValue - $minWork) / ($maxWork - $minWork) * 100)));

// // Устанавливаем вычисленное значение
// $this->setProperty($targetProperty, $newValue, 'worksUpdated');

// // При изменении CCT и выключенном статусе восстанавливаем уровень яркости
// if ($targetProperty === 'cct' && !$status) {
//     $this->setProperty('level', $this->getProperty('levelSaved') ?? 100, 'worksUpdated');
// }