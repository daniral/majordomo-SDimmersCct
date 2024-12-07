<?php

$colorNew = $params['NEW_VALUE'];
$colorOld = $params['OLD_VALUE'];
$brightnessSaved = $this->getProperty('brightnessSaved');

if ($colorNew == $colorOld) return;

if ($this->getProperty('flag')) {
	$this->setProperty('colorSaved', $colorNew);
}

$colorWork = '{"hex":"' . $colorNew . '"}';
$this->setProperty('colorWork', $colorWork);

//if (!$this->getProperty('status')) {
//	$this->callMethod('turnOn');
//}