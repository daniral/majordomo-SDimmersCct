<?php
/*
Выключение
*/
if($this->getProperty('status')){
    $this->setProperty('status', 0);
}
$this->setProperty('flag', 0);
$this->setProperty('illuminanceFlag', 0);
