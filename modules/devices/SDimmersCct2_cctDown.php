<?php
/*
Уменьшить температуру.(array("value"=>1--100)). Без  параметров 10.
*/

adjustProperty($this, 'cct', $params['value'] ?? null, 'down');