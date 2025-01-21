<?php
/*
Переводит из процентов (0 <--> 100) в рабочие еденицы яркости в предеелах (minWork <--> maxWork) 
Сохраняет предыдущее значение уровня в levelSaved
*/

$levelNew = $params['NEW_VALUE'];
$levelOld = $params['OLD_VALUE'];
$minWork = $this->getProperty('minWork');
$maxWork = $this->getProperty('maxWork');

if ($levelNew < 0 || $levelNew > 100) return;

if ($minWork != $maxWork) {
    $levelWork = round($minWork + round(($maxWork - $minWork) * $levelNew / 100));
    if($levelWork > 0) {
		$this->setProperty('levelWork', $levelWork);
        $this->setProperty('status', 1);
	}else {
        $this->callMethod('turnOff');
    }
    if ($levelNew > 0 && $this->getProperty('flag')) {
        $this->setProperty('levelSaved', $levelNew);
    }
}

