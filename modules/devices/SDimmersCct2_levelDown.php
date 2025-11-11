<?php
/*
Уменьшить яркость на (array("value"=>1--100)). Без  параметров на 10.
*/

adjustProperty($this, 'level', $params['value'] ?? null, 'down');