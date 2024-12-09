<?php

/*

Переводит рабочие еденицы яркости (minWork <--> maxWork) в проценты (0 <--> 100)
Сохраняет предыдущее значение уровня в levelSaved

*/

$brightnessLevelNew = $params['NEW_VALUE'];
$brightnessLevelOld = $params['OLD_VALUE'];
$minWork = $this->getProperty('minWork');
$maxWork = $this->getProperty('maxWork');


if ($brightnessLevelNew == $brightnessLevelOld || $brightnessLevelNew < 0 || $brightnessLevelNew > 100) return;

if ($minWork != $maxWork) {
    $brightLevelWork = round($minWork + round(($maxWork - $minWork) * $brightnessLevelNew / 100));
    $this->setProperty('levelWork', $brightLevelWork);
    if ($brightnessLevelNew > 0 && $this->getProperty('flag')) {
        $this->setProperty('levelSaved', $brightnessLevelNew);
    }
}
