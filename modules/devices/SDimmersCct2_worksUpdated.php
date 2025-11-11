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

$status   = $this->getProperty('status');
$source   = strtok($params['SOURCE'] ?? '', ' ');
$property = $params['PROPERTY'] ?? '';

$workValue = $params['NEW_VALUE'] ?? null;
if (!is_numeric($workValue)) return;
$workValue = (int)$workValue;

// Определяем диапазон и целевое свойство
switch ($property) {
    case 'levelWork':
        $minWork = $this->getProperty('levelMinWork');
        $maxWork = $this->getProperty('levelMaxWork');
        $targetProperty = 'level';
        break;

    case 'cctWork':
        $minWork = $this->getProperty('cctMinWork');
        $maxWork = $this->getProperty('cctMaxWork');
        $targetProperty = 'cct';
        break;

    default:
        return;
}

// Проверяем диапазон и источник
if ($minWork == $maxWork || $source === 'propertysUpdated') return;

// Ограничиваем значение строго в рамках диапазона
$workValue = max($minWork, min($maxWork, $workValue));

// Пересчитываем значение в проценты (0–100)
$newValue = (int)round(($workValue - $minWork) / ($maxWork - $minWork) * 100);
$newValue = max(0, min(100, $newValue));

// Обновляем основное свойство, если значение изменилось
if ($newValue != $this->getProperty($targetProperty)) {
    $this->setProperty($targetProperty, $newValue, 'worksUpdated');
}

// При изменении CCT и выключенном статусе восстанавливаем уровень
if ($targetProperty === 'cct' && !$status) {
    $this->setProperty('level', $this->getProperty('levelSaved'), 'worksUpdated');
}

// Сохраняем текущее значение для восстановления
if ($targetProperty === 'level' && $newValue > 0) {
    $this->setProperty('levelSaved', $newValue);
} elseif ($targetProperty === 'cct') {
    $this->setProperty('cctSaved', $newValue);
}
