<?php

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

// Пересчитываем 0–100
$newValue = (int)round(($workValue - $minWork) / ($maxWork - $minWork) * 100);
$newValue = max(0, min(100, $newValue));

// Обновляем основное свойство, если изменилось
if ($newValue != $this->getProperty($targetProperty)) {
    $this->setProperty($targetProperty, $newValue, 'worksUpdated');
}

// Сохраняем последнее значение
$this->setProperty($targetProperty . 'Saved', $newValue);
