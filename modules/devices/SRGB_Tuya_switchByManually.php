<?php

/*
При включении вручную отключить по солнцу и по датчику.
*/


if ($this->getProperty('byManually')) {
  $this->setProperty('bySunTime', '0');
  $this->setProperty('bySensor', '0');
}