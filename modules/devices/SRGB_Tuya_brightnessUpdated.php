<?php

/*

Переводит рабочие еденицы яркости (brightnessWorkMin <--> brightnessWorkMax) в проценты (0 <--> 100)
Сохраняет предыдущее значение уровня в brightnessSaved

*/

$brightnessLevelNew = $params['NEW_VALUE'];
$brightnessLevelOld = $params['OLD_VALUE'];
$brightnessWorkMin = $this->getProperty('brightnessWorkMin');
$brightnessWorkMax = $this->getProperty('brightnessWorkMax');


if ($brightnessLevelNew == $brightnessLevelOld || $brightnessLevelNew < 0 || $brightnessLevelNew > 100) return;

if ($brightnessWorkMin != $brightnessWorkMax) {
    $brightLevelWork = round($brightnessWorkMin + round(($brightnessWorkMax - $brightnessWorkMin) * $brightnessLevelNew / 100));
    $this->setProperty('brightnessWork', $brightLevelWork);
    if ($brightnessLevelNew > 0 && $this->getProperty('flag')) {
        $this->setProperty('brightnessSaved', $brightnessLevelNew);
    }
}
