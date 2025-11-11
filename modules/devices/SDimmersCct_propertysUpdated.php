<?php
/**
 * Обработчик изменения свойств (level, cct, presence).
 * 
* Рабочие диапазоны:
 * - levelMinWork / levelMaxWork
 * - cctMinWork / cctMaxWork
 */

$status   = $this->getProperty('status');
$source   = strtok($params['SOURCE'], ' ');
$property = $params['PROPERTY'];

$value = normalizeRange($params['NEW_VALUE'] ?? null);
if ($value === null) return;

// Сохраняем, если значение действительно изменилось
if ($value != ($params['OLD_VALUE'] ?? 0) && $value != $this->getProperty($property)) {
    $this->setProperty($property, $value, 'worksUpdated');
} else {
    return;
}

// Получаем min/max для вычисления рабочих значений
$levelMinWork = $this->getProperty('levelMinWork');
$levelMaxWork = $this->getProperty('levelMaxWork');
$cctMinWork   = $this->getProperty('cctMinWork');
$cctMaxWork   = $this->getProperty('cctMaxWork');

// При ручном управлении сбрасываем автофлаг
if ($source !== 'autoMode') {
    $this->setProperty('flag', 1);
}

// Рассчитываем рабочее значение и сохраняем текущее, если нужно
if ($property === 'level' && $levelMinWork != $levelMaxWork && $source !== 'worksUpdated') {
    $workValue = round($levelMinWork + ($levelMaxWork - $levelMinWork) * $value / 100);
    if ($value > 0 && $this->getProperty('flag')) {
        $this->setProperty('levelSaved', $value);
    }

} elseif ($property === 'cct' && $cctMinWork != $cctMaxWork && $source !== 'worksUpdated') {
    $workValue = round($cctMinWork + ($cctMaxWork - $cctMinWork) * $value / 100);
    if ($this->getProperty('flag')) {
        $this->setProperty('cctSaved', $value);
    }

} elseif ($property === 'presence' && !$value) {
    autoOff($this);
    return;

} else {
    return;
}

// При изменении cct и выключенном статусе восстанавливаем уровень яркости
if ($property === 'cct' && !$status) {
    $this->setProperty('level', $this->getProperty('levelSaved'));
}

// Устанавливаем вычисленное рабочее значение
$this->setProperty($property . 'Work', $workValue, 'propertysUpdated');
