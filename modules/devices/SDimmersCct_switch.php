<?php
/*
Переключить состояние.
Если было включено в авто режиме то включить то что в levelSaved и cctSaved.
Если было выключено включет то что в levelSaved и cctSaved.
Если было включено не в авто режиме то выключить.
*/

$status = (int)$this->getProperty('status');
$flag   = (int)$this->getProperty('flag');

if ($flag && $status) {
    // В авто режиме и уже включена — выключаем
    $this->callMethod('turnOff');
} else {
    // Во всех остальных случаях — включаем
    $this->callMethod('turnOn');
}