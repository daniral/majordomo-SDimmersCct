<?php

$status   = $this->getProperty('status');
$source   = strtok($params['SOURCE'], " ");
$property = $params['PROPERTY'];

$val = $params['NEW_VALUE'] ?? null;
if (!is_numeric($val)) return;

// Ограничиваем значение 0..100
$newValue = max(0, min(100, $val));

// Сохраняем, если значение вышло за пределы или отличается от текущего
if ($newValue != ($params['OLD_VALUE'] ?? 0)) {
    if ($newValue != $this->getProperty($property)) {
        $this->setProperty($property, $newValue, 'worksUpdated');
    }
} else {
    return;
}

// Получаем min/max значения для level и cct
$levelMinWork  = $this->getProperty('levelMinWork');
$levelMaxWork  = $this->getProperty('levelMaxWork');

$cctMinWork    = $this->getProperty('cctMinWork');
$cctMaxWork    = $this->getProperty('cctMaxWork');

// Рассчитываем рабочее значение
if ($property == 'level' && $levelMinWork != $levelMaxWork && $source != 'worksUpdated') {
    $workValue = round($levelMinWork + ($levelMaxWork - $levelMinWork) * $newValue / 100);
} elseif ($property == 'cct' && $cctMinWork != $cctMaxWork && $source != 'worksUpdated') {
    $workValue = round($cctMinWork + ($cctMaxWork - $cctMinWork) * $newValue / 100);
} else {
    return;
}

// Устанавливаем рабочее значение и сохранённое
$this->setProperty($property . 'Work', $workValue, 'propertysUpdated');
$this->setProperty($property . 'Saved', $newValue);
