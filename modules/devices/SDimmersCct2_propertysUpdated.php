<?php
/**
 * Обработчик изменения свойств (level, cct, presence).
 *
 * Логика:
 * - При изменении level или cct значение пересчитывается в рабочий диапазон (MinWork/MaxWork)
 *   и записывается в соответствующее свойство levelWork или cctWork.
 * - При изменении presence срабатывает автоотключение.
 * - При ручном управлении (не autoMode) сбрасывается флаг автоуправления.
 * - Сохраняются последние заданные значения levelSaved и cctSaved.
 *
 * Рабочие диапазоны:
 * - levelMinWork / levelMaxWork
 * - cctMinWork / cctMaxWork
 *
 * @param array $params [
 *     'SOURCE' => string Источник изменения (например, propertysUpdated, autoMode и т.д.)
 *     'PROPERTY' => string Изменяемое свойство (level, cct, presence)
 *     'NEW_VALUE' => mixed Новое значение (0–100)
 *     'OLD_VALUE' => mixed Старое значение
 * ]
 */

$source   = strtok($params['SOURCE'], ' ');
$property = $params['PROPERTY'];
$maxWork = ($property=='level') ? $this->getProperty('levelMaxWork') : $this->getProperty('cctMaxWork');
$minWork = ($property=='level') ? $this->getProperty('levelMinWork') : $this->getProperty('cctMinWork');
$value = strtolower(trim($params['NEW_VALUE'] ?? null));

$presets = [
	'coolest' => 0,
	'cool'    => 33,
	'warm'    => 66,
	'warmest' => 100,
];
if (isset($presets[$value])) {
	$value = $presets[$value];
}

$value = normalizeRange($value, 0, 100, 'number');

// Проверяем диапазон и источник
if ($minWork == $maxWork || $source === 'worksUpdated' || $value === null) return;

//Сохраняем, если значение действительно изменилось
if ($value != $this->getProperty($property)) 
   $this->setProperty($property, $value, 'worksUpdated');

if ($property === 'presence') {
    if ((int)$this->getProperty('timerOff') > 0) {
        autoOff($this);
    }
    return;
}

if ($value <= 0 && $property === 'level') {
	$this->callMethod('turnOff');
	return;
}

// Вычисляем рабочее значение в рамках диапазона
$workValue = round($minWork + ($maxWork - $minWork) * $value / 100);

// Устанавливаем вычисленное рабочее значение
$this->setProperty($property . 'Work', $workValue, 'propertysUpdated');

if ($source !== 'autoMode'){
	$this->setProperty('flag', 1);
	$this->setProperty($property . 'Saved', $value);
}

if(!$this->getProperty('status') && $value > 0)
	$this->setProperty('status', 1);







// $status   = $this->getProperty('status');
// $source   = strtok($params['SOURCE'], ' ');
// $property = $params['PROPERTY'];
// $value = strtolower(trim($params['NEW_VALUE'] ?? null));

// if ($source === 'worksUpdated') return;

// switch ($property) {
//     case 'level':
//         $minWork = $this->getProperty('levelMinWork');
//         $maxWork = $this->getProperty('levelMaxWork');
// 		if ($value <= 0) {
// 			$this->callMethod('turnOff');
// 			return;
// 		}
// 		if(!$status && $value > 0){
// 			$this->setProperty('status', 1);
// 		}
//         break;

//     case 'cct':
// 		$minWork = $this->getProperty('cctMinWork');
//         $maxWork = $this->getProperty('cctMaxWork');
		
// 		$presets = [
// 			'coolest' => 0,
// 			'cool'    => 33,
// 			'warm'    => 66,
// 			'warmest' => 100,
// 		];

// 		if (isset($presets[$value])) {
// 			$value = $presets[$value];
// 		}
//         break;
		
// 	case 'presence':
// 		if(!$value){
// 			autoOff($this);
// 		}
// 		return;
			
//     default:
//         return;
// }

// // Проверяем диапазон и источник
// if ($minWork == $maxWork) return;

// $value = normalizeRange($value ?? null);
// if ($value === null) return;

// //Сохраняем, если значение действительно изменилось
// if ($value != ($params['OLD_VALUE'] ?? 0) && $value != $this->getProperty($property)) 
//    $this->setProperty($property, $value, 'worksUpdated');

// // Вычисляем рабочее значение в рамках диапазона
// $workValue = round($minWork + ($maxWork - $minWork) * $value / 100);

// // Устанавливаем вычисленное рабочее значение
// $this->setProperty($property . 'Work', $workValue, 'propertysUpdated');

// if ($source !== 'autoMode'){
// 	$this->setProperty('flag', 1);
// 	if ($property=='level' && $value > 0){
// 		$this->setProperty('levelSaved', $value);
// 	}
// 	if ($property=='cct') {
// 		$this->setProperty('cctSaved', $value);
// 	}
// }