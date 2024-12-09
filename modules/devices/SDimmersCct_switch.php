<?php
/*
Переключить состояние Вкл/Выкл.
если было включено в режиме подсветки то включить то что в brightnessLevelSeved и cctLevelSeved.
Еще запуск выключит.
Если было выключено включет то что в brightnessLevelSeved и cctLevelSeved.
*/

if (!$this->getProperty('level') && !$this->getProperty('flag')) {
  $this->callMethod('turnOn');
} else if ($this->getProperty('level') && !$this->getProperty('flag')) {
  $this->callMethod('turnOn');
} else if ($this->getProperty('level') && $this->getProperty('flag')) {
  $this->callMethod('turnOff');
}