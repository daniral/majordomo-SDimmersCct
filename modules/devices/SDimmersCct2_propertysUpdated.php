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

$status   = $this->getProperty('status');
$source   = strtok($params['SOURCE'], ' ');
$property = $params['PROPERTY'];
$value = strtolower(trim($params['NEW_VALUE'] ?? null));

switch ($property) {
    case 'level':
        $minWork = $this->getProperty('levelMinWork');
        $maxWork = $this->getProperty('levelMaxWork');
        break;

    case 'cct':
		$minWork = $this->getProperty('cctMinWork');
        $maxWork = $this->getProperty('cctMaxWork');
		
		$presets = [
			'coolest' => 0,
			'cool'    => 33,
			'warm'    => 66,
			'warmest' => 100,
		];

		if (isset($presets[$value])) {
			$value = $presets[$value];
		}
        break;
		
	case 'presence':
		if(!$value){
			autoOff($this);
		}
		return;
			
    default:
        return;
}

// Проверяем диапазон и источник
if ($minWork == $maxWork || $source === 'worksUpdated') return;

$value = normalizeRange($value ?? null,1);
if ($value === null) return;

//Сохраняем, если значение действительно изменилось
if ($value != ($params['OLD_VALUE'] ?? 0) && $value != $this->getProperty($property)) 
   $this->setProperty($property, $value, 'worksUpdated');

// Вычисляем рабочее значение в рамках диапазона
$workValue = round($minWork + ($maxWork - $minWork) * $value / 100);

// Устанавливаем вычисленное рабочее значение
$this->setProperty($property . 'Work', $workValue, 'propertysUpdated');

if ($property=='cct' && !$status) {
	$this->setProperty('level', $this->getProperty('levelSaved') ?? 100, 'propertysUpdated');
}

if ($source !== 'autoMode'){
	$this->setProperty('flag', 1);
	$this->setProperty($property . 'Saved', $value);
}

if(!$status) $this->setProperty('status', 1);
