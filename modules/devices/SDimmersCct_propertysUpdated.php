<?php
/**
 * Обработчик изменения свойств (level, cct, presence).
 *
 * Логика:
 * - При изменении level или cct значение пересчитывается в рабочий диапазон (MinWork/MaxWork)
 *   и записывается в соответствующее свойство levelWork или cctWork.
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
// --- Дефолтные свойства
$this->callMethod('byDefault');

$status   = $this->getProperty('status');
$source   = strtok($params['SOURCE'], " ");
$property = $params['PROPERTY'];
$value = $params['NEW_VALUE'] ?? null;

switch ($property) {
    case 'level':
        $minWork = $this->getProperty('levelMinWork');
        $maxWork = $this->getProperty('levelMaxWork');
        break;

    case 'cct':
        $presets = [
			'coolest' => 1,
			'cool'    => 33,
			'warm'    => 66,
			'warmest' => 100,
		];
        if (isset($presets[$value])) {
            $value = $presets[$value];
        }
        $minWork = $this->getProperty('cctMinWork');
        $maxWork = $this->getProperty('cctMaxWork');
        break;

    default:
        return;
}

// Проверяем диапазон и источник
if ($minWork == $maxWork || $source === 'worksUpdated') return;

$value = normalizeRange($value ?? null,1);
if ($value === null) return;

// Сохраняем, если значение вышло за пределы или отличается от текущего
if ($value != ($params['OLD_VALUE'] ?? 0) && $value != $this->getProperty($property))
        $this->setProperty($property, $value, 'worksUpdated');

$this->setProperty($property . 'Saved', $value);
	
if ($property=='cct' && !$status) {
	$this->setProperty('level', $this->getProperty('levelSaved') ?? 100, 'propertysUpdated');
}

// Вычисляем рабочее значение в рамках диапазона
$workValue = round($minWork + ($maxWork - $minWork) * $value / 100);

// Устанавливаем рабочее значение
$this->setProperty($property . 'Work', $workValue, 'propertysUpdated');

if(!$status) $this->setProperty('status', 1);
