<?php
/*
Переключить состояние Вкл/Выкл.
если было включено в режиме подсветки то включить то что в brightnessSaved и cctLevelSeved.
Еще запуск выключит.
Если было выключено включет то что в brightnessSaved и cctLevelSeved.
*/

if (!$this->getProperty('brightness') && !$this->getProperty('flag')) {
  $this->callMethod('turnOn');
} else if ($this->getProperty('brightness') && !$this->getProperty('flag')) {
  $this->callMethod('turnOn');
} else if ($this->getProperty('brightness') && $this->getProperty('flag')) {
  $this->callMethod('turnOff');
}