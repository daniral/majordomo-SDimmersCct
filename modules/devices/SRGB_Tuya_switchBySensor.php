<?php

/*
При включении сенсора света отключить по солнцу и вручную.
*/


if ($this->getProperty('bySensor')) {
  $this->setProperty('bySunTime', '0');
  $this->setProperty('byManually', '0');
}