<?php

/*
Запускается при изменении свойства presence
если 0 запустить autoOff
*/

if (!$this->getProperty('presence')) {
  $this->callMethod('autoOff');
}