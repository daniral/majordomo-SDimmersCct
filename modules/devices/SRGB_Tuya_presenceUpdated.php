<?php

/*
Запускается при изменении свойства presence
если 0 запустить AutoOFF
*/

if (!$this->getProperty('presence')) {
  $this->callMethod('AutoOFF');
}