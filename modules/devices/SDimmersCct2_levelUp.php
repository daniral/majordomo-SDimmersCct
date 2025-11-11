<?php
/*
Увеличить яркость.(array('value'=>1--100)). Без  параметров 10.
*/

adjustProperty($this, 'level', $params['value'] ?? null, 'up');