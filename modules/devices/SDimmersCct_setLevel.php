<?php

if (isset($params['value']) && is_numeric($params['value'])) {
    $this->setProperty('level', max(0, min(100, $params['value'])));
}