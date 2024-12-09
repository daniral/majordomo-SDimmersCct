<?php

/*

Запускается при изменении рабочнго уровня.
Переводит в проценты и пишет в level.

*/

/*
$brightnessWorkNew = $params['NEW_VALUE'];
$brightnessWorkOld = $params['OLD_VALUE'];
$minWork = $this->getProperty('minWork');
$maxWork = $this->getProperty('maxWork');

if ($brightnessWorkNew == $brightnessWorkOld || $brightnessWorkNew < $minWork || $brightnessWorkNew > $maxWork) return;

if ($minWork != $maxWork) {
    $level = round(($brightnessWorkNew - $minWork) / (round($maxWork - $minWork)) * 100);
    $this->setProperty('level', $level,'','levelWorkChanged');
}
*/