<?php
/*
Переключить состояние Вкл/Выкл.
если было включено в авто режиме то включить то что в levelSaved и cctSeved.
Еще запуск выключит.
Если было выключено включет то что в levelSaved и cctSeved.
*/

if (!$this->getProperty('status') && !$this->getProperty('flag')) {
  $this->callMethod('turnOn');
} else if ($this->getProperty('status') && !$this->getProperty('flag')) {
  $this->callMethod('turnOn');
} else if ($this->getProperty('status') && $this->getProperty('flag')) {
  $this->callMethod('turnOff');
}