<?php

/*

Переводит рабочие еденицы теплоты (cctWorkMin <--> cctWorkMax) в проценты (0 <--> 100)
Сохраняет предыдущее значение уровня в cctSeved

*/

$cctLevelNew = $params['NEW_VALUE'];
$cctLevelOld = $params['OLD_VALUE'];
$cctWorkMin = $this->getProperty('cctWorkMin');
$cctWorkMax = $this->getProperty('cctWorkMax');
$levelSaved = $this->getProperty('levelSaved');

if ($cctLevelNew == $cctLevelOld || $cctLevelNew < 0 || $cctLevelNew > 100) return;

if ($cctWorkMin != $cctWorkMax) {
	$cctLevelWork = round($cctWorkMin + round(($cctWorkMax - $cctWorkMin) * $cctLevelNew / 100));
	$this->setProperty('cctWork', $cctLevelWork);
	if ($this->getProperty('flag')) {
		$this->setProperty('cctSeved', $cctLevelNew);
	}
	if (!$this->getProperty('level')) {
		$this->setProperty('level', $levelSaved ? $levelSaved : 100);
	}
}
