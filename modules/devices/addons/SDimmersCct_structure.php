<?php

if (SETTINGS_SITE_LANGUAGE && file_exists(ROOT . 'languages/SDimmersCct_' . SETTINGS_SITE_LANGUAGE . '.php')) {
	include_once(ROOT . 'languages/SDimmersCct_' . SETTINGS_SITE_LANGUAGE . '.php');
} else {
	include_once(ROOT . 'languages/SDimmersCct_default.php'); //
}

$this->device_types['dimmerCct'] = array(
	'TITLE' => 'Освещение(Яркость,Температура)',
	'PARENT_CLASS' => 'SDimmers',
	'CLASS' => 'SDimmersCct',
	'PROPERTIES' => array(
		'level' => array('DESCRIPTION' => 'Яркость (0-100)', 'ONCHANGE' => 'propertysUpdated', 'DATA_KEY' => 1,'VALIDATION_TYPE' => 1, 'VALIDATION_NUM_MIN' => 0, 'VALIDATION_NUM_MAX' => 100),
		'levelWork' => array('DESCRIPTION' => 'Рабочая яркость.', 'ONCHANGE' => 'worksUpdated'),
		'levelSaved' => array('DESCRIPTION' => 'Сохраненная яркость.'),
		'cct' => array('DESCRIPTION' => 'Температура (0-100)', 'ONCHANGE' => 'propertysUpdated', 'DATA_KEY' => 1,'VALIDATION_TYPE' => 1, 'VALIDATION_NUM_MIN' => 0, 'VALIDATION_NUM_MAX' => 100),
		'cctWork' => array('DESCRIPTION' => 'Рабочая теплота.', 'ONCHANGE' => 'worksUpdated'),
		'cctSaved' => array('DESCRIPTION' => 'Сохраненная теплота.'),
		'levelMaxWork' => array('DESCRIPTION' => 'Максимальная рабочая яркость', '_CONFIG_TYPE' => 'num'),
		'levelMinWork' => array('DESCRIPTION' => 'Минимальная рабочая яркость', '_CONFIG_TYPE' => 'num'),
		'cctMaxWork' => array('DESCRIPTION' => 'Максимальная рабочая теплота', '_CONFIG_TYPE' => 'num'),
		'cctMinWork' => array('DESCRIPTION' => 'Минимальная рабочая теплота', '_CONFIG_TYPE' => 'num'),
	),
	'METHODS' => array(
		'setLevel' => array('DESCRIPTION' => 'Установить уровень яркости.', '_CONFIG_SHOW' => 1, '_CONFIG_REQ_VALUE' => 1),
		'setCct' => array('DESCRIPTION' => 'Установить уровень температуры.', '_CONFIG_SHOW' => 1, '_CONFIG_REQ_VALUE' => 1),
		'levelUp' => array('DESCRIPTION' => 'Увеличить уровень яркости.', '_CONFIG_SHOW' => 1, '_CONFIG_REQ_VALUE' => 1),
		'levelDown' => array('DESCRIPTION' => 'Уменьшить уровень яркости.', '_CONFIG_SHOW' => 1, '_CONFIG_REQ_VALUE' => 1),
		'cctUp' => array('DESCRIPTION' => 'Увеличить уровень температуры.', '_CONFIG_SHOW' => 1, '_CONFIG_REQ_VALUE' => 1),
		'cctDown' => array('DESCRIPTION' => 'Уменьшить уровень температуры.', '_CONFIG_SHOW' => 1, '_CONFIG_REQ_VALUE' => 1),
		'propertysUpdated' => array('DESCRIPTION' => 'Запускается при смене яркости или температуры.'),
		'worksUpdated' => array('DESCRIPTION' => 'Запускается при смене рабочей яркости или температуры.'),
	),
);
