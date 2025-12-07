<?php
/**
 * Class SDimmersCct
 *
 * PROPERTIES:
 *
 * @property int    $level          Яркость (0–100). OnChange: propertysUpdated. DataKey.
 * @property int    $levelWork      Рабочая яркость.
 * @property int    $levelSaved     Сохраненная яркость.
 * @property int    $cct            Температура (0–100). OnChange: propertysUpdated. DataKey.
 * @property int    $cctWork        Рабочая теплота.
 * @property int    $cctSaved       Сохраненная теплота.
 * @property int    $levelMaxWork   Максимальная рабочая яркость (config).
 * @property int    $levelMinWork   Минимальная рабочая яркость (config).
 * @property int    $cctMaxWork     Максимальная рабочая теплота (config).
 * @property int    $cctMinWork     Минимальная рабочая теплота (config).
 * 
 * METHODS:
 *
 * @method void setLevel(int $value)   Установить уровень яркости (0–100)
 * @method void setCct(int $value)     Установить уровень температуры (0–100)
 * @method void levelUp(int $step)     Увеличить уровень яркости
 * @method void levelDown(int $step)   Уменьшить уровень яркости
 * @method void cctUp(int $step)       Увеличить уровень температуры
 * @method void cctDown(int $step)     Уменьшить уровень температуры
 * @method void propertysUpdated()     Срабатывает при изменении яркости или температуры
 * @method void worksUpdated()         Срабатывает при изменении рабочих параметров яркости/температуры
 * @method void byDefault()        	   Установить свойства по умолчанию
 */

if (SETTINGS_SITE_LANGUAGE && file_exists(ROOT . 'languages/SDimmersCct_' . SETTINGS_SITE_LANGUAGE . '.php')) {
	include_once(ROOT . 'languages/SDimmersCct_' . SETTINGS_SITE_LANGUAGE . '.php');
} else {
	include_once(ROOT . 'languages/SDimmersCct_default.php'); //
}

$this->device_types['dimmerCct'] = array(
	'TITLE' => 'Освещение(Яркость,Температура)',
	'PARENT_CLASS' => 'SControllers',
	'CLASS' => 'SDimmersCct',
	'PROPERTIES' => array(
		'level' => array('DESCRIPTION' => 'Яркость (0-100)', 'ONCHANGE' => 'propertysUpdated', 'DATA_KEY' => 1),
		'levelWork' => array('DESCRIPTION' => 'Рабочая яркость.', 'ONCHANGE' => 'worksUpdated'),
		'levelSaved' => array('DESCRIPTION' => 'Сохраненная яркость.'),
		'levelMaxWork' => array('DESCRIPTION' => 'Максимальная рабочая яркость', '_CONFIG_TYPE' => 'num'),
		'levelMinWork' => array('DESCRIPTION' => 'Минимальная рабочая яркость', '_CONFIG_TYPE' => 'num'),

		'cct' => array('DESCRIPTION' => 'Температура (0-100)', 'ONCHANGE' => 'propertysUpdated', 'DATA_KEY' => 1),
		'cctWork' => array('DESCRIPTION' => 'Рабочая теплота.', 'ONCHANGE' => 'worksUpdated'),
		'cctSaved' => array('DESCRIPTION' => 'Сохраненная теплота.'),
		'cctMaxWork' => array('DESCRIPTION' => 'Максимальная рабочая теплота', '_CONFIG_TYPE' => 'num'),
		'cctMinWork' => array('DESCRIPTION' => 'Минимальная рабочая теплота', '_CONFIG_TYPE' => 'num'),
	),
	'METHODS' => array(
		'setLevel' => array('DESCRIPTION' => 'Установить уровень яркости.', '_CONFIG_SHOW' => 1, '_CONFIG_REQ_VALUE' => 1),
		'levelUp' => array('DESCRIPTION' => 'Увеличить уровень яркости.', '_CONFIG_SHOW' => 1, '_CONFIG_REQ_VALUE' => 1),
		'levelDown' => array('DESCRIPTION' => 'Уменьшить уровень яркости.', '_CONFIG_SHOW' => 1, '_CONFIG_REQ_VALUE' => 1),
		'setCct' => array('DESCRIPTION' => 'Установить уровень температуры.', '_CONFIG_SHOW' => 1, '_CONFIG_REQ_VALUE' => 1),
		'cctUp' => array('DESCRIPTION' => 'Увеличить уровень температуры.', '_CONFIG_SHOW' => 1, '_CONFIG_REQ_VALUE' => 1),
		'cctDown' => array('DESCRIPTION' => 'Уменьшить уровень температуры.', '_CONFIG_SHOW' => 1, '_CONFIG_REQ_VALUE' => 1),

		'propertysUpdated' => array('DESCRIPTION' => 'Запускается при смене яркости или температуры.'),
		'worksUpdated' => array('DESCRIPTION' => 'Запускается при смене рабочей яркости или температуры.'),
	),
);
