<?php

/*
При включении по солнцу отключить по датчику счета и вручную.
*/


if ($this->getProperty('bySunTime')) {
  $this->setProperty('bySensor', '0');
  $this->setProperty('byManually', '0');
}
