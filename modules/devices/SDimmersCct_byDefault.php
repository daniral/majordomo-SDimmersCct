<?php

/*
Установить свойства по умолчанию.
Установки для AqaraBulbZigBee.
Для других надо менять
*/
$defaults = [
    'dayLevel' => '100', 'dayCct' => '0',
    'nightLevel' => '30', 'nightCct' => '100',
    'levelMinWork' => '0', 'levelMaxWork' => '254',
    'cctMinWork' => '153', 'cctMaxWork' => '370',
    'timerOff' => '45', 'presence' => '0',
    'dayBegin' => '08:00', 'nightBegin' => '18:00',
    'autoOnOff' => '1', 'flag' => '0', 'illuminanceFlag' => '0',
    'illuminance' => '0', 'illuminanceMax' => '0',
    'workingDay' => '2', 'workingBy' => '1',
    'addTimeSunrise' => '00:00', 'addTimeSunset' => '00:00',
    'signSunrise' => '1', 'signSunset' => '1',
    'sunriseTime' => '08:00', 'sunsetTime' => '18:00'
];
initDefaults($this, $defaults);