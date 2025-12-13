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
//


// --- Дефолтные свойства
$this->callMethod('byDefault');

// --- Обработка свойств
$source   = strtok($params['SOURCE'], ' ');
$property = $params['PROPERTY'];
$maxWork = ($property=='level') ? $this->getProperty('levelMaxWork') : $this->getProperty('cctMaxWork');
$minWork = ($property=='level') ? $this->getProperty('levelMinWork') : $this->getProperty('cctMinWork');
$value = strtolower(trim($params['NEW_VALUE'] ?? null));

// Обработка пресетов для CCT
$presets = [
	'coolest' => 0,
	'cool'    => 33,
	'warm'    => 66,
	'warmest' => 100,
];
if (isset($presets[$value])) {
	$value = $presets[$value];
}

// Нормализуем значение
$value = normalizeRange($value, 0, 100, 'number');

// Проверяем диапазон и источник
if ($minWork == $maxWork || $source === 'worksUpdated' || $value === null) return;

//Сохраняем, если значение действительно изменилось
if ($value != $this->getProperty($property)) 
   $this->setProperty($property, $value, 'worksUpdated');

// Обработка presence
if ($property === 'presence') {
    if ((int)$this->getProperty('timerOff') > 0) {
        autoOff($this);
    }
    return;
}
// Выключаем, если уровень яркости 0
if ($value <= 0 && $property === 'level') {
	$this->callMethod('turnOff');
	return;
}

// Вычисляем рабочее значение в рамках диапазона
$workValue = (int)round($minWork + ($maxWork - $minWork) * $value / 100);

// Устанавливаем вычисленное рабочее значение
$this->setProperty($property . 'Work', $workValue, 'propertysUpdated');

// При изменении CCT и выключенном статусе восстанавливаем уровень яркости
if ($property === 'cct' && !$this->getProperty('status')) {
    $this->setProperty('level', $this->getProperty('levelSaved') ?? 100, 'worksUpdated');
}

// Установка флага запрета автоуправления и сохранение последних значений
if ($source !== 'autoMode'){
	$this->setProperty('flag', 1);
	$this->setProperty($property . 'Saved', $value);
}
// Проверка статуса и установка включенного состояния
if(!$this->getProperty('status') && $value > 0)
	$this->setProperty('status', 1);