<?php
/*
Переключить состояние Вкл/Выкл.
если было включено в режиме подсветки то включить то что в levelSaved и cctSeved.
Еще запуск выключит.
Если было выключено включет то что в levelSaved и cctSeved.
*/

if (!$this->getProperty('level') && !$this->getProperty('flag')) {
  $this->callMethod('turnOn');
} else if ($this->getProperty('level') && !$this->getProperty('flag')) {
  $this->callMethod('turnOn');
} else if ($this->getProperty('level') && $this->getProperty('flag')) {
  $this->callMethod('turnOff');
}