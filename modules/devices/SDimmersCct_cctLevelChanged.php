<?php

/*

Переводит рабочие еденицы теплоты (cctWorkMin <--> cctWorkMax) в проценты (0 <--> 100)
Сохраняет предыдущее значение уровня в cctLevelSeved

*/

$cctLevelNew = $params['NEW_VALUE'];
$cctLevelOld = $params['OLD_VALUE'];
$cctWorkMin = $this->getProperty('cctWorkMin');
$cctWorkMax = $this->getProperty('cctWorkMax');
$brightnessLevelSeved = $this->getProperty('brightnessLevelSeved');

if ($cctLevelNew == $cctLevelOld || $cctLevelNew < 0 || $cctLevelNew > 100) return;

if ($cctWorkMin != $cctWorkMax) {
	$cctLevelWork = round($cctWorkMin + round(($cctWorkMax - $cctWorkMin) * $cctLevelNew / 100));
	$this->setProperty('cctWork', $cctLevelWork);
	if ($this->getProperty('flag')) {
		$this->setProperty('cctLevelSeved', $cctLevelNew);
	}
	if (!$this->getProperty('level')) {
		$this->setProperty('level', $brightnessLevelSeved ? $brightnessLevelSeved : 100);
	}
}
