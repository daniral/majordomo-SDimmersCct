<?php

if (isset($params['value']) && is_numeric($params['value'])) {
    $this->setProperty('cct', max(0, min(100, $params['value'])));
}
